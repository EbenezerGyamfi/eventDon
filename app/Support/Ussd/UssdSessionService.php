<?php

namespace App\Support\Ussd;

use App\Models\Attendee;
use App\Models\AttendeeToDonate;
use App\Models\DonationTransaction;
use App\Models\Event;
use App\Models\Question;
use App\Notifications\SendMessage;
use App\Support\Phone\PhoneService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Ramsey\Uuid\Uuid;

class UssdSessionService implements UssdSessionContract
{
    public function handleUssdSession(array $requestBody): array
    {
        // Handle all timeouts
        if ($requestBody['userData'] == 'User timeout') {
            return [
                'sessionID' => $requestBody['sessionID'],
                'userID' => $requestBody['userID'],
                'msisdn' => $requestBody['msisdn'],
                'message' => $this->buildMessage('User timeout'),
                'continueSession' => false,
            ];
        }

        $response = $this->handleNewUssdSession($requestBody);

        if ($response['status'] === 'completed') {
            $response = $this->handleSubsequentUssdSessions($requestBody);
            if ($response['status'] === 'completed') {
                $event = $this->eventCodeExists($requestBody['userData']);
                $attendee = $event->attendees()->where('phone', $requestBody['msisdn'])->first();
                $this->sendProgramLineUp($attendee);

                return [
                    'sessionID' => $requestBody['sessionID'],
                    'userID' => $requestBody['userID'],
                    'msisdn' => $requestBody['msisdn'],
                    'message' => $this->buildMessage($response['message']),
                    'continueSession' => false,
                ];
            }
        }

        if ($response['status'] === 'next') {
            $response = $this->handleSubsequentUssdSessions($requestBody);

            if ($response['status'] === 'completed') {
                return [
                    'sessionID' => $requestBody['sessionID'],
                    'userID' => $requestBody['userID'],
                    'msisdn' => $requestBody['msisdn'],
                    'message' => $this->buildMessage($response['message']),
                    'continueSession' => false,
                ];
            }

            if ($response['status'] === 'error') {
                return [
                    'sessionID' => $requestBody['sessionID'],
                    'userID' => $requestBody['userID'],
                    'msisdn' => $requestBody['msisdn'],
                    'message' => $this->buildMessage('Invalid user or session!'),
                    'continueSession' => false,
                ];
            }
        }

        return [
            'sessionID' => $requestBody['sessionID'],
            'userID' => $requestBody['userID'],
            'msisdn' => $requestBody['msisdn'],
            'message' => $this->buildMessage($response['message']),
            'continueSession' => true,
        ];
    }

    public function handleNewUssdSession(array $requestBody): array
    {
        if (
            $requestBody['newSession']
            && ($event = $this->eventCodeExists($requestBody['userData']))
        ) {
            $question = $this->retrieveQuestionToAskUser(
                $event,
                $requestBody['msisdn'],
                $requestBody['sessionID']
            );

            if (! $question) {
                return [
                    'status' => 'completed',
                    'message' => $event->goodbye_message,
                ];
            }

            return [
                'status' => 'success',
                'message' => "{$question->event->greeting_message}\n{$question->question}",
            ];
        }

        return [
            'status' => 'next',
            'message' => 'Next',
        ];
    }

    public function eventCodeExists(string $eventCode): ?Event
    {
        $event = Event::whereHas(
            'ussdExtension',
            fn ($query) => $query->where('code', $eventCode)
        )
            ->ongoing()
            ->first();

        if (is_null($event)) {
            $event = Event::whereHas(
                'preRegistrationUssdExtension',
                fn ($query) => $query->where('code', $eventCode)
            )
                ->isInPreRegistration()
                ->first();
        }

        return $event;
    }

    private function retrieveQuestionToAskUser(
        Event $event,
        string $phone,
        string $sessionId
    ): ?Question {
        $attendee = $event
            ->attendees()
            ->where('phone', $phone)
            ->first();

        if (! $attendee) {
            $attendee = $event
                ->attendees()
                ->create([
                    'phone' => $phone,
                ]);
        }

        if ($event->inPreRegistration()) {
            $attendee->update(['ussd_session_id' => $sessionId, 'has_pre_registered' => true]);

            return $event->preRegistrationQuestions()
                ->whereDoesntHave(
                    'answers',
                    fn ($query) => $query->whereHas(
                        'attendee',
                        fn ($queryTwo) => $queryTwo
                            ->where('id', $attendee->id)
                    )
                )
                ->first();
        } else {
            $attendee->update(['ussd_session_id' => $sessionId, 'is_present' => true]);

            return $event->questions()
                ->whereDoesntHave(
                    'answers',
                    fn ($query) => $query->whereHas(
                        'attendee',
                        fn ($queryTwo) => $queryTwo
                            ->where('id', $attendee->id)
                    )
                )
                ->first();
        }
    }

    public function handleSubsequentUssdSessions(array $requestBody): array
    {
        $attendee = Attendee::with('event')
            ->whereHas('event', function ($query) {
                return $query->ongoing()
                    ->orWhere(function ($query) {
                        return $query->isInPreRegistration();
                    });
            })
            ->where('phone', $requestBody['msisdn'])
            ->where('ussd_session_id', $requestBody['sessionID'])
            ->first();

        if (! $attendee) {
            return [
                'status' => 'error',
                'message' => 'Error',
            ];
        }

        $questionToAnswer = $this->retrieveQuestionForUser($attendee);

        if (! $questionToAnswer) {
            if (! $attendee->event->inPreRegistration()) {
                $acceptedToDonate = AttendeeToDonate::with('event')
                    ->whereHas('event', function ($query) {
                        return $query->ongoing()
                            ->orWhere(function ($query) {
                                return $query->isInPreRegistration();
                            });
                    })
                    ->where('phone', $requestBody['msisdn'])
                    ->where('ussd_session_id', $requestBody['sessionID'])
                    ->first();

                if (! $acceptedToDonate) {
                    return $this->askDonationAndAmount($requestBody, $attendee);
                } else {
                    if ($this->validateDonationAmount($requestBody['userData'])) {
                        $response = $this->initiateDonationPayment($attendee, $requestBody);

                        if ($response) {
                            $responseData = $response['Data'];
                            $this->saveDonationTransaction($attendee, $responseData, $requestBody['msisdn']);
                            $this->sendProgramLineUp($attendee);

                            return [
                                'status' => 'completed',
                                'message' => 'Kindly accept payment by entering your PIN in the next prompt. You may also dial *170# and select Options 6 and 3',
                            ];
                        } else {
                            $this->sendProgramLineUp($attendee);

                            return [
                                'status' => 'error',
                                'message' => 'There was an error while processing your payment. Kindly try again',
                            ];
                        }
                    } elseif (! empty($requestBody['userData'])) {
                        return [
                            'status' => 'next',
                            'message' => 'Wrong amount entered. Kindly enter a valid amount you want to donate',
                        ];
                    } else {
                        return [
                            'status' => 'next',
                            'message' => 'Kindly enter the amount you want to donate',
                        ];
                    }
                }
            } else {
                return [
                    'status' => 'completed',
                    'message' => $attendee->event->goodbye_message,
                ];
            }
        }

        $questionToAnswer->answers()->create([
            'attendee_id' => $attendee->id,
            'answer' => $requestBody['userData'],
        ]);

        if (strtolower($questionToAnswer->title) == 'name') {
            $attendee->contact?->update(['name' => $requestBody['userData']]);
        }

        $question = $this->retrieveQuestionToAskUser(
            $questionToAnswer->event,
            $requestBody['msisdn'],
            $requestBody['sessionID']
        );

        if (! $question) {
            if (! $attendee->event->inPreRegistration()) {
                $acceptedToDonate = AttendeeToDonate::with('event')
                    ->whereHas('event', function ($query) {
                        return $query->ongoing()
                            ->orWhere(function ($query) {
                                return $query->isInPreRegistration();
                            });
                    })
                    ->where('phone', $requestBody['msisdn'])
                    ->where('ussd_session_id', $requestBody['sessionID'])
                    ->first();

                if (! $acceptedToDonate) {
                    return $this->askDonationAndAmount($requestBody, $attendee);
                } else {
                    if ($this->validateDonationAmount($requestBody['userData'])) {
                        $response = $this->initiateDonationPayment($attendee, $requestBody);

                        if ($response) {
                            $responseData = $response['Data'];
                            $this->saveDonationTransaction($attendee, $responseData, $requestBody['msisdn']);
                            $this->sendProgramLineUp($attendee);

                            return [
                                'status' => 'completed',
                                'message' => 'Kindly accept payment by entering your PIN in the next prompt. You may also dial *170# and select Options 6 and 3',
                            ];
                        } else {
                            $this->sendProgramLineUp($attendee);

                            return [
                                'status' => 'error',
                                'message' => 'There was an error while processing your payment. Kindly try again',
                            ];
                        }
                    } elseif (! empty($requestBody['userData'])) {
                        return [
                            'status' => 'next',
                            'message' => 'Wrong amount entered. Kindly enter a valid amount you want to donate',
                        ];
                    } else {
                        return [
                            'status' => 'next',
                            'message' => 'Kindly enter the amount you want to donate',
                        ];
                    }
                }
            } else {
                return [
                    'status' => 'completed',
                    'message' => $attendee->event->goodbye_message,
                ];
            }
        }

        return [
            'status' => 'success',
            'message' => $question->question,
        ];
    }

    private function retrieveQuestionForUser(Attendee $attendee): ?Question
    {
        $event = $attendee->event;

        if ($event->inPreRegistration()) {
            return $event
                ->preRegistrationQuestions()
                ->whereDoesntHave(
                    'answers',
                    fn ($query) => $query->whereHas(
                        'attendee',
                        fn ($queryTwo) => $queryTwo
                            ->where('phone', $attendee->phone)
                            ->where('event_id', $attendee->event->id)
                    )
                )
                ->first();
        } else {
            return $event
                ->questions()
                ->whereDoesntHave(
                    'answers',
                    fn ($query) => $query->whereHas(
                        'attendee',
                        fn ($queryTwo) => $queryTwo
                            ->where('phone', $attendee->phone)
                            ->where('event_id', $attendee->event->id)
                    )
                )
                ->first();
        }
    }

    private function sendProgramLineUp(Attendee $attendee)
    {
        $event = $attendee->event;

        $plan = $event->plan;

        $numberOfAttendees = $plan->getFeatureValue('number_of_attendees');

        $attendeeCount = $event->attendees()
            ->isPresent()
            ->count();

        if ($attendeeCount > $numberOfAttendees) {
            return;
        }

        if (
            ! is_null($event->program_lineup) &&
            ! $event->inPreRegistration()
        ) {
            $link = URL::signedRoute('events.program-lineup-link', ['event' => $event->id]);
            $message = "Thank you for checking in. Please click the link below to download the program lineup for $event->name. \n $link";
            $attendee->notify(new SendMessage([
                'message' => $message,
                'sender' => config('app.sender'),
            ]));
        }
    }

    private function buildMessage(string $message)
    {
        return "Powered by eventsdon.com \n\n".$message;
    }

    private function attendeeWantsToDonate(array $requestBody, Attendee $attendee): bool
    {
        if (trim(strtolower($requestBody['userData'])) === '1') {
            if (AttendeeToDonate::create([
                'ussd_session_id' => $requestBody['sessionID'],
                'event_id' => $attendee->event_id,
                'phone' => $requestBody['msisdn'],
                'attendee_id' => $attendee->id,
            ])) {
                return true;
            }

            return false;
        }

        return false;
    }

    private function attendeeDoesntWantToDonate(string $response): bool
    {
        return trim(strtolower($response)) === '2';
    }

    private function validateDonationAmount(string $amount): ?float
    {
        $amount = filter_var($amount, FILTER_VALIDATE_FLOAT);

        return ($amount !== false && $amount > 0) ? $amount : null;
    }

    private function askDonationAndAmount(array $requestBody, Attendee $attendee): array
    {
        if ($this->attendeeWantsToDonate($requestBody, $attendee)) {
            return [
                'status' => 'next',
                'message' => 'Kindly enter the amount you want to donate',
            ];
        } elseif ($this->attendeeDoesntWantToDonate($requestBody['userData'])) {
            $this->sendProgramLineUp($attendee);

            return [
                'status' => 'completed',
                'message' => $attendee->event->goodbye_message,
            ];
        } else {
//            $attendeeName = $this->getAttendeeName($attendee);
            return [
                'status' => 'next',
                'message' => "Hello, Would you like to make a donation to support us?\n1. Yes\n2. No",
            ];
        }
    }

    private function saveDonationTransaction(Attendee $attendee, $responseData, $msisdn): void
    {
        DonationTransaction::create([
            'attendee_id' => $attendee->id,
            'amount' => $responseData['Amount'],
            'amount_after_charges' => $responseData['AmountAfterCharges'],
            'transaction_id' => $responseData['TransactionId'],
            'description' => $responseData['Description'],
            'event_id' => $attendee->event->id,
            'msisdn' => $msisdn,
            'reference_id' => $responseData['ReferenceId'],
        ]);
    }

    private function initiateDonationPayment(Attendee $attendee, array $requestBody): mixed
    {
        $response = Http::withBasicAuth(config('ebits.payment.username'), config('ebits.payment.password'))
            ->post(config('ebits.payment.url').'/api/v1/direct-payment/initiate', [
                'customer_name' => $attendee->answers->first()->answer,
                'customer_msisdn' => $requestBody['msisdn'],
                'customer_email' => 'austy2012@gmail.com',
                'amount' => $requestBody['userData'],
                'channel' => PhoneService::getChannel($requestBody['msisdn']),
                'description' => "Donation of {$requestBody['userData']} for {$attendee->event->name}",
                'callback_url' => route('donations.webhook'),
                'merchantAccountNumber' => '2017377',
                'merchant_reference' => Uuid::uuid4(),
            ])->json();

        return $response;
    }

    /*private function getAttendeeName(Attendee $attendee)
    {
        return $attendee->answers()->where (['title' => 'Name'])->first ()->answer ?? '';
        return $attendee->event->questions->where ('title', 'Name')->first()?->answers->where ('attendee_id', $attendee->id)->first()?->answer ?? '';
    }*/
}
