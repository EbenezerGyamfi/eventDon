<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventAttendeesExport implements FromCollection, WithHeadings
{
    protected $questionTitles;

    public function __construct(
        protected Event $event,
        protected bool $preRegisteredAttendees = false
    ) {
        if ($this->preRegisteredAttendees) {
            $questions = $this->event->preRegistrationQuestions->pluck('title');
        } else {
            $questions = $this->event->questions->pluck('title');
        }

        $questions = $questions
            ->map(fn ($title) => ucfirst(strtolower($title)))
            ->toArray();

        $this->questionTitles = $questions;
    }

    public function headings(): array
    {
        $headings = array_merge(
            $this->questionTitles,
            [
                'Phone Number',
                'Created At',
            ]
        );

        return $headings;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $plan = $this->event->plan;

        $attendees = $this->event
            ->attendees();

        if ($this->preRegisteredAttendees) {
            $attendees = $attendees
                ->hasPreRegistered();
        } else {
            $attendees = $attendees
                ->isPresent();
        }

        $attendees = $attendees
            ->latest('created_at')
            ->take($plan->getFeatureValue('number_of_attendees'))
            ->get();

        return $attendees->map(function ($attendee) {
            $answers = [];
            for ($i = 0; $i < count($this->questionTitles); $i++) {
                $answers[strtolower($this->questionTitles[$i])] = 'Not Answered';
            }

            $attendee->answers->each(function ($answer) use (&$answers) {
                $answers[strtolower($answer->question->title)] = $answer->answer;
            });

            return array_merge($answers, [
                'phone' => $attendee->phone,
                'created_at' => $attendee->created_at,
            ]);
        });
    }
}
