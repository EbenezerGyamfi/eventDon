<?php

namespace App\Http\Controllers\Events\Client;

use App\DataTables\EventAttendeesDataTable;
use App\DataTables\EventPreRegisteredAttendeesDataTable;
use App\Exports\EventAttendeesExport;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientEventAttendeeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $event = Event::with(['questions', 'plan'])
            ->withCount('questions')->find($id);

        $this->authorize('view', $event);

        $questionTitles = $event->questions->pluck('title');

        $dataTable = new EventAttendeesDataTable($event);

        $plan = $event->plan;

        $attendeesLimit = $plan->getFeatureValue('number_of_attendees');

        $numberOfPresentAttendees = $event->attendees()
            ->isPresent()
            ->count();

        return $dataTable->with('event', $event)
            ->with('questionTitles', $questionTitles)
            ->render('client.events.attendees', [
                'event' => $event,
                'page_title' => 'Event - '.$event->name,
                'attendeesLimit' => $attendeesLimit,
                'numberOfPresentAttendees' => $numberOfPresentAttendees,
            ]);
    }

    public function showPreRegisteredAttendees($id)
    {
        $event = Event::with([
            'preRegistrationQuestions',
            'plan',
        ])
        ->withCount('preRegisteredAttendees')
        ->find($id);

        $this->authorize('view', $event);

        $plan = $event->plan;

        $attendeesLimit = $plan->getFeatureValue('number_of_attendees');

        $questionTitles = $event->preRegistrationQuestions->pluck('title');

        $dataTable = new EventPreRegisteredAttendeesDataTable($event, $questionTitles);

        return $dataTable
            ->with('questionTitles', $questionTitles)
            ->render('client.events.pre-registered-attendees', [
                'event' => $event,
                'page_title' => 'Event - '.$event->name,
                'attendeesLimit' => $attendeesLimit,
                'numberOfPreRegisteredAttendees' => $event->pre_registered_attendees_count,
            ]);
    }

    public function search(Request $request, Event $event)
    {
        $this->authorize('view', $event);

        $request->validate([
            'term' => ['nullable', 'string'],
        ]);

        $searchTerm = $request->query('term');

        $attendees = $event->attendees()->select(['id', 'phone'])
            ->where('phone', 'like', '%'.$searchTerm.'%')
            ->whereHas('answers', function ($query) use ($searchTerm) {
                return $query->whereHas('question', fn ($query) => $query->where('title', 'Name'))
                    ->where('answer', 'like', '%'.$searchTerm.'%');
            })
            ->with([
                'answers' => function ($query) {
                    return $query
                        ->whereHas('question', fn ($query) => $query->where('title', 'Name'));
                },
            ])
            ->isPresent()
            ->paginate(15);

        return $attendees;
    }

    public function export(Request $request, $id)
    {
        $preRegisteredAttendees = $request->boolean('pre_registered');
        $event = Event::with(
            [
                'attendees' => function ($query) use ($preRegisteredAttendees) {
                    $preRegisteredAttendees
                        ? $query->hasPreRegistered()
                        : $query->isPresent();
                },
                'attendees.answers' => function ($query) use ($preRegisteredAttendees) {
                    return $query->whereHas('question', function ($query) use ($preRegisteredAttendees) {
                        return $query->where('pre_registration', $preRegisteredAttendees);
                    });
                },
                'attendees.answers.question',
            ]
        )
            ->withCount('questions')
            ->findOrFail($id);

        $this->authorize('view', $event);

        $filename = $preRegisteredAttendees
            ? $event->name.' Pre-registered - '.now()
            : $event->name.' - '.now();

        return Excel::download(
            new EventAttendeesExport(
                $event,
                $preRegisteredAttendees
            ),
            $filename.'.csv'
        );
    }
}
