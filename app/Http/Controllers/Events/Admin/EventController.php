<?php

namespace App\Http\Controllers\Events\Admin;

use App\DataTables\Admin\EventDataTable;

use App\DataTables\Admin\EventTicketsDataTable;

use App\DataTables\Admin\EventDonationDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\Api\StoreEventRequest;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Question;
use App\Models\UssdExtension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EventDataTable $dataTable)
    {
        $data['statistics'] = [
            'events' => Event::count(),
            'events_yesterday' => Event::beforeToday()->count(),
            'upcoming_events' => Event::upcoming()->count(),
            'upcoming_events_yesterday' => Event::upcoming()->beforeToday()->count(),
            'ongoing_events' => Event::ongoing()->count(),
            'ongoing_events_hour_ago' => Event::wasOngoingAnHourAgo()->count(),
            'first_for_users_events' => Event::firstForUsers()->count(),
            'first_for_users_events_yesterday' => Event::firstForUsers()->beforeToday()->count(),
        ];

        $data['page_title'] = 'Events';

        return $dataTable->render('admin.events.index', $data);
    }

    public function ticketSalesdetails(Event $event)
    {

        
        $dataTable = new EventTicketsDataTable($event);

        $eventName = $event->name;
    

        return  $dataTable->render('admin.events.tickets-details',compact('eventName') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Create event';

        return view('admin.events.create', ['codes' => UssdExtension::all()->pluck('code')->toArray(), 'page_title' => $page_title]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        //
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

        $data['question'] = Question::where('event_id', $id)->get();

        return view('admin.events.show', [
            'page_title' => 'Event - '.$event->name,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function eventDonationDetails(Event $event)
    {
        $dataTable = new EventDonationDataTable($event);

        $totalAmount = $event->donations->sum('amount');
        $totalAmountCharges = $event->donationTransactions->sum('amount');
         $eventName = $event->name;

        return  $dataTable->render('admin.events.donation-details', compact('totalAmount', 'totalAmountCharges','eventName'));
    }
}
