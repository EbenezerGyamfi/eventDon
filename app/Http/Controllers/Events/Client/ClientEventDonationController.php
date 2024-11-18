<?php

namespace App\Http\Controllers\Events\Client;

use App\DataTables\EventDonationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDonationRequest;
use App\Models\Donation;
use App\Models\Event;
use Illuminate\Http\Request;

class ClientEventDonationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($id, EventDonationsDataTable $dataTable)
    {
        $event = Event::with('donations')->findOrFail($id);

        $this->authorize('view', $event);

        return $dataTable->with('event', $event)
            ->render('client.events.donation', [
                'event' => $event,
                'totalDonations' => $event->donations()->sum('amount'),
                'page_title' => "Donations for {$event->name}",
            ]);
    }

    public function create(Event $event)
    {
        $this->authorize('addDonation', $event);

        return view('client.donation.create', compact('event'));
    }

    public function show(Event $event, Donation $donation)
    {
        $this->authorize('view', $event);

        return view('client.donation.invoice', compact('donation'));
    }

    public function store(StoreDonationRequest $request, Event $event)
    {
        $this->authorize('addDonation', $event);

        $attendee = null;

        if (! $request->no_phone) {
            $attendee = $event->attendees()
                ->find($request->attendee_id);

            if (is_null($attendee)) {
                return back()->withErrors(['error' => 'Invalid operation. Please refresh the page and try again']);
            }
        } else {
            $attendee = $event->attendees()->create([
                'is_present' => true,
            ]);

            $nameQuestion = $event->questions()
                ->where('title', 'Name')
                ->first();

            if (! is_null($nameQuestion)) {
                $attendee->answers()->create([
                    'question_id' => $nameQuestion->id,
                    'answer' => $request->name,
                ]);
            }
        }

        $event->donations()->create(array_merge(
            $request->only('amount', 'name'),
            [
                'user_id' => auth()->id(),
                'attendee_id' => $attendee->id,
                'phone' => $attendee->phone,
                'type' => 'manual',
            ]
        ));

        return back()->with('message', 'Donation recorded successfully');
    }
}
