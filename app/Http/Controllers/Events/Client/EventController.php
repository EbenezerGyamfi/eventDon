<?php

namespace App\Http\Controllers\Events\Client;

use App\DataTables\EventDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\Api\StoreEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Imports\GuestsImport;
use App\Models\Event;
use App\Models\UssdExtension;
use App\Support\Events\EventService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EventDataTable $dataTable)
    {
        $user = auth()->user();

        $statistics = [];

        if (! $user->isTeller) {
            $statistics = [
                'total_events' => $user->events()->count(),
                'events_yesterday' => $user->events()->beforeToday()->count(),
                'upcoming_events' => $user->events()->upcoming()->count(),
                'ongoing_events' => $user->events()->ongoing()->count(),
                'first_for_users_events' => $user->events()->firstForUsers()->count(),
                'first_for_users_events_yesterday' => $user->events()->firstForUsers()->beforeToday()->count(),
            ];
        }

        return $dataTable->render('client.events.index', [
            'statistics' => $statistics,
            'page_title' => 'Events',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.events.create', [
            'contactGroups' => auth()
                ->user()
                ->contactGroups()
                ->has('contacts')
                ->get()
                ->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request, EventService $eventService)
    {
        $ussdExtension = $this->getAvailableUssdExtension(
            $request->start_time,
            $request->end_time
        );

        $preRegistrationExtension = $request->enable_pre_registration
            ? (new UssdExtension)->getAvailableExtensionForPreRegistration(
                $request->pre_registration_start_time,
                $request->pre_registration_end_time
            )
            : null;

        $ticketingExtension = $request->ticketing
            ? (new UssdExtension)->getAvailableExtensionForTicketing(
                $request->ticketing_start_time,
                $request->ticketing_end_time,
            )
            : null;

        if (is_null($ussdExtension)) {
            return response()->json(
                [
                    'error' => 'There is no USSD extension available in this time frame',
                ],
                422
            );
        }

        if (is_null($preRegistrationExtension) && $request->enable_pre_registration) {
            return response()->json(
                [
                    'error' => 'There is no USSD extension available for pre registration in this time frame',
                ],
                422
            );
        }

        if (is_null($ticketingExtension) && $request->ticketing) {
            return response()->json(
                [
                    'error' => 'There is no USSD extension available for ticketing in this time frame',
                ],
                422
            );
        }

        $plan = $eventService->getEventPlan($request->expected_attendees);

        if (is_null($plan)) {
            return response()->json(['error' => 'Please contact support for custom pricing for your event'], 422);
        }

        $wallet = auth()->user()->mainWallet;

        if ($wallet->balance < $plan->price) {
            return response()->json(['error' => 'Insufficient Balance, kindly top up'], 422);
        }

        try {
            DB::transaction(function () use ($eventService, $ussdExtension, $request, $plan, $preRegistrationExtension, $ticketingExtension) {
                $event = $eventService->store(
                    $ussdExtension,
                    $request,
                    $plan,
                    $preRegistrationExtension,
                    $ticketingExtension
                );

                if ($request->hasFile('program_lineup')) {
                    $path = $this->saveProgramLineup($request->file('program_lineup'), $event);
                    $event->update(['program_lineup' => $path]);
                }

                if ($request->hasFile('guest-list-file')) {
                    $this->processGuestList($request->file('guest-list-file'), $event, $request->post('guests_per_table'));
                }

                return true;
            });
        } catch (\Exception $e) {
            report($e);
        }

        return $request->ajax()
            ? response()->json(['message' => 'Event created successfully'])
            : redirect()->route('events.index')->with('message', 'Event created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::with(['ussdExtension', 'preRegistrationUssdExtension', 'questions', 'plan'])
            ->withCount([
                'attendees' => fn ($query) => $query->isPresent(),
                'attendees as pre_registered_attendees_count' => fn ($query) => $query->hasPreRegistered(),
                'attendees as total_attendees',
                'questions',
                'answers',
                'smsHistories',
            ])
            ->find($id);

        $this->authorize('view', $event);

        $attendanceProgress = 0;

        if ($event->total_attendees != 0) {
            $attendanceProgress = round(
                ($event->attendees_count / $event->total_attendees) * 100,
                2
            );
        }

        $programLineUpLink = '';
        if ($event->program_lineup) {
            $programLineUpLink = URL::signedRoute('events.program-lineup-link', ['event' => $event->id]);
        }

        $smsCredits = $event->plan->getFeatureValue('sms_credits');

        $remainingSmsCredits = $smsCredits - $event->sms_histories_count;

        if ($remainingSmsCredits < 0) {
            $remainingSmsCredits = 0;
        }

        return view('client.events.show', [
            'event' => $event,
            'attendanceProgress' => $attendanceProgress,
            'page_title' => $event->name.' details',
            'programLineUpLink' => $programLineUpLink,
            'smsCredits' => $smsCredits,
            'remainingSmsCredits' => $remainingSmsCredits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $event->load(['questions', 'tellers']);

        return view('client.events.edit', [
            'event' => $event,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        $data = $request->only(['name', 'venue', 'greeting_message', 'goodbye_message']);

        if ($request->has('start_time')) {
            $data = array_merge($data, [
                'start_time' => Carbon::parse($request->input('start_time')),
                'end_time' => Carbon::parse($request->input('end_time')),
            ]);

            if (
                $event->start_time != $data['start_time']
                || $event->end_time != $data['end_time']
            ) {
                if ($event->shouldChangeAttendanceUssdExtension(
                    $data['start_time'],
                    $data['end_time']
                )) {
                    $ussdExtension = (new UssdExtension)
                        ->getAvailableExtension(
                            $data['start_time'],
                            $data['end_time']
                        );

                    if (is_null($ussdExtension)) {
                        return response()->json(['error' => 'There is no USSD extension available in this time frame'], 422);
                    }
                    $data['ussd_extension_id'] = $ussdExtension->id;
                }
            }
        }

        if ($request->has('ticketing_start_time')) {
            $data = array_merge($data, [
                'ticketing_start_time' => Carbon::parse($request->input('ticketing_start_time')),
                'ticketing_end_time' => Carbon::parse($request->input('ticketing_end_time')),
            ]);

            if (
                $event->ticketing_start_time != $data['ticketing_start_time']
                || $event->ticketing_end_time != $data['ticketing_end_time']
            ) {
                if ($event->shouldChangeTicketingUssdExtension(
                    $data['ticketing_start_time'],
                    $data['ticketing_end_time']
                )) {
                    $ticketingUssdExtension = (new UssdExtension)
                        ->getAvailableExtensionForTicketing(
                            $data['ticketing_start_time'],
                            $data['ticketing_end_time']
                        );

                    if (is_null($ticketingUssdExtension)) {
                        return response()->json(['error' => 'There is no USSD extension available for ticketing in this time frame'], 422);
                    }
                    $data['ticketing_ussd_extension_id'] = $ticketingUssdExtension->id;
                }
            }
        }

        if ($request->hasFile('program_lineup')) {
            $data['program_lineup'] = $this->saveProgramLineup($request->file('program_lineup'), $event);
        }

        $event->update($data);

        $event->tellers()->detach();

        if (! is_null($request->selected_users)) {
            $event->tellers()->attach($request->selected_users);
        }

        return redirect()->route('events.index')->with('message', 'Event Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        // Disble event deletion for now
        // $this->authorize('delete', $event);

        // $event->answers()->delete();

        // $event->questions()->delete();

        // $event->attendees()->delete();

        // $event->delete();

        return back()->with('message', 'Event deleted');
    }

    private function saveProgramLineup($file, Event $event): string
    {
        return $file->storePubliclyAs(
            'events/'.$event->id,
            Str::slug($event->name).'.'.$file->extension(),
            'public'
        );
    }

    private function processGuestList($file, Event $event, int $guestsPerTable)
    {
        (new GuestsImport(auth()->user(), $event, $guestsPerTable))->queue($file);
    }

    private function getAvailableUssdExtension(string $start_time, string $end_time): ?UssdExtension
    {
        return (new UssdExtension)
            ->getAvailableExtension(
                now()->parse($start_time),
                now()->parse($end_time)
            );
    }
}
