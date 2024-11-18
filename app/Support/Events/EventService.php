<?php

namespace App\Support\Events;

use App\Http\Requests\Events\Api\StoreEventRequest;
use App\Jobs\PopulateAttendeesFromContactGroups;
use App\Models\Event;
use App\Models\Plan;
use App\Models\PlanFeature;
use App\Models\Question;
use App\Models\UssdExtension;
use App\Support\Users\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventService
{
    public function store(
        UssdExtension $ussdExtension,
        StoreEventRequest $request,
        Plan $plan,
        ?UssdExtension $preRegistrationUssdExtension,
        ?UssdExtension $ticketingExtension
    ): Event {
        return DB::transaction(function () use ($ussdExtension, $request, $plan, $preRegistrationUssdExtension, $ticketingExtension) {
            $data = array_merge(
                $request->only(
                    [
                        'name', 'venue', 'expected_attendees',
                        'greeting_message', 'goodbye_message', 'contact_group_id',
                        'type', 'ticketing',
                    ]
                ),
                [
                    'start_time' => Carbon::parse($request->start_time),
                    'end_time' => Carbon::parse($request->end_time),
                    'user_id' => auth()->user()->id,
                    'pre_registration_ussd_extension_id' => $preRegistrationUssdExtension?->id,
                    'can_pre_register' => $request->enable_pre_registration,
                    'ask_pre_registration_questions' => $request->enable_pre_registration_questions,
                    'plan_id' => $plan->id,
                    'ticketing_ussd_extension_id' => $ticketingExtension?->id,
                ]
            );

            if ($request->enable_pre_registration) {
                $data = array_merge($data, [
                    'pre_registration_start_time' => Carbon::parse($request->pre_registration_start_time),
                    'pre_registration_end_time' => Carbon::parse($request->pre_registration_end_time),
                ]);
            }

            if ($request->ticketing) {
                $data = array_merge($data, [
                    'ticketing_start_time' => Carbon::parse($request->ticketing_start_time),
                    'ticketing_end_time' => Carbon::parse($request->ticketing_end_time),
                ]);
            }

            $event = $ussdExtension->events()->create($data);

            if ($event->ticketing) {
                $event->ticketTypes()->insert(
                    array_map(fn ($ticket) => [
                        'name' => $ticket['name'],
                        'price' => $ticket['price'],
                        'no_of_available_tickets' => $ticket['no_of_available_tickets'],
                        'event_id' => $event->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ], $request->tickets)
                );
            }

            if (! is_null($request->selected_users)) {
                $event->tellers()->attach($request->selected_users);
            }

            $event = $this->saveEventQuestions($event, $request);

            $userService = new UserService;
            $userService->chargeWallet($plan->price, 'Paid for an event');

            if ($event->contact_group_id) {
                dispatch(new PopulateAttendeesFromContactGroups($event));
            }

            return $event;
        });
    }

    private function saveEventQuestions(
        Event &$event,
        StoreEventRequest $request
    ): Event {
        if (! is_null($request->questions)) {
            $questions = collect($request->questions)
                ->map(fn ($question) => new Question([
                    'question' => $question['question'],
                    'title' => $question['title'],
                    'order' => $question['order'],
                ]))->all();

            $event->questions()->saveMany($questions);
        }

        if (! is_null($request->pre_registration_questions) && $request->enable_pre_registration) {
            $questions = collect($request->pre_registration_questions)
                ->map(fn ($question) => new Question([
                    'question' => $question['question'],
                    'title' => $question['title'],
                    'order' => $question['order'],
                    'pre_registration' => true,
                ]))->all();

            $event->preRegistrationQuestions()->saveMany($questions);
        }

        return $event;
    }

    public function getEventPlan(int $expectedAttendees): ?Plan
    {
        $plan = PlanFeature::with('plan')
            ->where('value', '>=', $expectedAttendees)
            ->whereHas('feature', fn ($query) => $query->where('name', 'number_of_attendees'))
            ->orderBy('value', 'ASC')
            ->first()
            ?->plan;

        return $plan;
    }
}
