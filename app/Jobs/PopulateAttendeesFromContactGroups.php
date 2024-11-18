<?php

namespace App\Jobs;

use App\Models\Answer;
use App\Models\Attendee;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PopulateAttendeesFromContactGroups implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Event $event)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $attendees = $this
            ->event
            ->contactGroup
            ->contacts
            ->map(function ($contact) {
                return new Attendee([
                    'phone' => $contact->phone,
                    'event_id' => $this->event->id,
                    'ussd_session_id' => $contact->name,
                    'contact_id' => $contact->id,
                ]);
            })
            ->toArray();

        $this
            ->event
            ->attendees()
            ->createMany($attendees);

        // $questionId = $this->event->questions->first()->id;
        // $now = Carbon::now()->toDateTimeString();

        // $answers = $this
        //     ->event
        //     ->attendees()
        //     ->createMany($attendees)
        //     ->filter(fn ($attendee) => $attendee->ussd_session_id !== null)
        //     ->map(function ($attendee) use ($questionId, $now) {
        //         return new Answer([
        //             'attendee_id' => $attendee->id,
        //             'question_id' => $questionId,
        //             'answer' => $attendee->ussd_session_id,
        //             'created_at' => $now,
        //             'updated_at' => $now,
        //         ]);
        //     })
        //     ->toArray();

        // Answer::insert($answers);
    }
}
