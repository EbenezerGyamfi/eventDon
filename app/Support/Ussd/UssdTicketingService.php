<?php

namespace App\Support\Ussd;

use App\Models\Attendee;
use App\Models\DonationTransaction;
use App\Models\Event;
use App\Models\Ticket;
use App\Support\Payment\PaymentService;
use App\Support\Phone\PhoneService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class UssdTicketingService implements UssdSessionContract
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
            return [
                'sessionID' => $requestBody['sessionID'],
                'userID' => $requestBody['userID'],
                'msisdn' => $requestBody['msisdn'],
                'message' => $this->buildMessage($response['message']),
                'continueSession' => false,
            ];
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
                    'message' => isset($response['message'])
                        ? $this->buildMessage($response['message'])
                        : $this->buildMessage('Invalid user or session!'),
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
            /*$requestBody['newSession']
            && */($event = $this->eventCodeExists($requestBody['userData']))
        ) {
            $key = $requestBody['msisdn'].'|'.$requestBody['sessionID'];

            Cache::put($key, [
                'event' => $event,
                'next_stage' => 'ST1',
            ], 1200); // store in cache for 20 minutes

            return [
                'status' => 'success',
                'message' => $this->getStage('INIT', $event)['message'],
            ];
        }

        return [
            'status' => 'next',
            'message' => 'Next',
        ];
    }

    public function handleSubsequentUssdSessions(array $requestBody): array
    {
        $key = $this->getCacheKey($requestBody);

        $data = Cache::get($key);

        $stage = $this->getStage($data['next_stage'], $data['event']);

        switch ($data['next_stage']) {
            case 'ST1':
                return $this->processStageOne($data, $requestBody, $stage);
                break;
            case 'ST2':
                return $this->processStageTwo($data, $requestBody, $stage);
                break;

            case 'ST3':
                return $this->processStageThree($data, $requestBody, $stage);
                break;

            case 'ST4':
                return $this->processStageFour($data, $requestBody, $stage);
                break;

            case 'ST5':
                return $this->processStageFive($data, $requestBody, $stage);
                break;

            case 'DST1':
                return $this->processDonationStageOne($data, $requestBody, $stage);
                break;

            case 'DST2':
                return $this->processDonationStageTwo($data, $requestBody, $stage);
                break;
        }
    }

    public function eventCodeExists(string $eventCode): ?Event
    {
        $event = Event::whereHas(
            'ticketingUssdExtension',
            fn ($query) => $query->where('code', $eventCode)
        )
            ->isInTicketing()
            ->first();

        return $event;
    }

    private function getStage($stage, $event): ?array
    {
        $stages = [
            'INIT' => [
                'message' => "Welcome to {$event->name}. What do you want to do?\n1. Purchase Tickets\n2. Make a donation",
            ],
            'ST1' => [
                'message' => 'Purchase tickets for '.$event->name."\nEnter 1 to proceed",
            ],
            'ST2' => [
                'message' => '%d. %s - GHC %.2f ', // Eg. 1. Regular GHC 1
            ],
            'ST3' => [
                'message' => '1 %s ticket = GHC %.2f '.' Enter how many tickets you would like to purchase',
            ],
            'ST4' => [
                'message' => '%d ticket(s) at GHC %.2f. Please enter 1 to confirm',
            ],
            'ST5' => [
                'message' => 'Please wait for the prompt to complete payment',
            ],

            'DST1' => [
                'message' => 'Kindly enter the amount you want to donate',
            ],
            'DST2' => [
                'message' => "You have requested to donate GHS%.2f.\n1. Confirm\n2. Cancel",
            ],
        ];

        return $stages[$stage] ?? null;
    }

    private function processStageOne($data, $requestBody, $stage): array
    {
        $key = $this->getCacheKey($requestBody);
        $event = $data['event'];

        if ($requestBody['userData'] == 1) {
            $data['next_stage'] = 'ST2';
            Cache::put($key, $data, 1200);

            return [
                'message' => $this->getStage('ST1', $event)['message'],
                'status' => 'success',
            ];
        }

        if ($requestBody['userData'] == 2) {
            $data['next_stage'] = 'DST1';
            Cache::put($key, $data, 1200);

            return [
                'message' => $this->getStage('DST1', $event)['message'],
                'status' => 'success',
            ];
        }

//        return [
//            'message' => $this->getStage ('ST1', $event)['message'],
//            'status' => 'success',
//        ];
    }

    private function processStageTwo($data, $requestBody, $stage): array
    {
        $key = $this->getCacheKey($requestBody);

        if (
            (int) $requestBody['userData'] == 1
        ) {
            $event = $data['event'];

            $message = '';

            foreach ($event->ticketTypes as $index => $ticketType) {
                $message .= sprintf(
                    $stage['message'],
                    $index + 1,
                    $ticketType->name,
                    $ticketType->price
                )."\n";
            }

            $data['next_stage'] = 'ST3';
            Cache::put($key, $data, 1200);

            return [
                'message' => $message,
                'status' => 'success',
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Invalid Input',
            ];
        }
    }

    private function processStageThree($data, $requestBody, $stage): array
    {
        $key = $this->getCacheKey($requestBody);

        $index = (int) $requestBody['userData'];

        $event = $data['event'];

        $ticketTypes = $event->ticketTypes->toArray();

        if (
            array_key_exists($index - 1, $ticketTypes)
        ) {
            $ticketType = $ticketTypes[$index - 1];
            $message = sprintf($stage['message'], $ticketType['name'], $ticketType['price']);

            $data['next_stage'] = 'ST4';
            $data['selected_ticket_type'] = $ticketType['id'];

            Cache::put($key, $data, 1200);

            return [
                'message' => $message,
                'status' => 'success',
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Invalid Input',
            ];
        }
    }

    private function processStageFour($data, $requestBody, $stage): array
    {
        $key = $this->getCacheKey($requestBody);

        $numberOfTickets = (int) $requestBody['userData'];

        if ($numberOfTickets < 1) {
            return [
                'status' => 'error',
                'message' => 'The number minimum number of tickets you can purchase is 1',
            ];
        }

        // can we sell more tickets ?
        $event = $data['event'];
        $selectedTicketType = $event->ticketTypes()->find($data['selected_ticket_type']);
        $soldTickets = (int) Ticket::where('event_id', $event->id)
            ->where('ticket_type_id', $selectedTicketType->id)
            ->sum('no_of_tickets');
        $numberOfAvialableTickets = $selectedTicketType->no_of_available_tickets;

        if ($soldTickets === $numberOfAvialableTickets) {
            return [
                'status' => 'error',
                'message' => $selectedTicketType->name.' tickets are sold out',
            ];
        }

        if (($soldTickets + $numberOfTickets) > $numberOfAvialableTickets) {
            $remainingTicketCount = $numberOfAvialableTickets - $soldTickets;

            $message = 'Only '
                .$remainingTicketCount
                .' '
                .$selectedTicketType->name
                .' '
                .Str::plural('ticket', $remainingTicketCount);

            if ($remainingTicketCount === 1) {
                $message .= ' is left';
            } else {
                $message .= ' are left';
            }

            return [
                'status' => 'error',
                'message' => $message,

            ];
        }

        $totalCost = $selectedTicketType->price * $numberOfTickets;
        $data['number_of_tickets'] = $numberOfTickets;
        $data['total_cost'] = $totalCost;
        $data['next_stage'] = 'ST5';
        $message = sprintf($stage['message'], $numberOfTickets, $totalCost);

        Cache::put($key, $data, 1200);

        return [
            'status' => 'success',
            'message' => $message,
        ];
    }

    private function processStageFive($data, $requestBody, $stage): array
    {
        $key = $this->getCacheKey($requestBody);

        if (
            (int) $requestBody['userData'] == 1
        ) {
            $event = $data['event'];
            $selectedTicketType = $event->ticketTypes()->find($data['selected_ticket_type']);
            $paymentData = [
                'account_number' => $requestBody['msisdn'],
                'amount' => floatval($data['total_cost']),
                'provider' => strtolower($requestBody['network']),
                'description' => 'Purchase of '
                    .$data['number_of_tickets']
                    .' '
                    .$selectedTicketType->name
                    .' tickets',
                'metadata' => [
                    'event_id' => $event->id,
                    'buyer_contact' => $requestBody['msisdn'],
                    'number_of_tickets' => $data['number_of_tickets'],
                    'ticket_type_id' => $data['selected_ticket_type'],
                ],
            ];
            $paymentService = new PaymentService(PaymentService::$PROVIDER_HUBTEL);
            $response = $paymentService->charge($paymentData);

            Cache::delete($key);

            return match ($response['status']) {
                'success' => [
                    'status' => 'completed',
                    'message' => $stage['message'],
                ],
                'error' => [
                    'status' => 'error',
                    'message' => 'Payment could not be initiated. Please try again',
                ]
            };
        } else {
            return [
                'status' => 'error',
                'message' => 'Invalid Input',
            ];
        }
    }

    private function processDonationStageOne($data, $requestBody, $stage): array
    {
        $key = $this->getCacheKey($requestBody);
        $event = $data['event'];

        if ($this->validateDonationAmount($requestBody['userData'])) {
            $data['next_stage'] = 'DST2';
            Cache::put($key, $data, 1200);

            Cache::put('donationAmount', $requestBody['userData'], 1200);

            $message = sprintf(
                $this->getStage('DST2', $event)['message'],
                $requestBody['userData']
            );
        } else {
            return [
                'message' => 'Invalid amount entered. Kindly enter a valid amount to donate',
                'status' => 'success',
            ];
        }

        return [
            'message' => $message,
            'status' => 'success',
        ];
    }

    private function processDonationStageTwo($data, $requestBody, $stage): array
    {
        $key = $this->getCacheKey($requestBody);
        $amount = Cache::get('donationAmount');
        $event = $data['event'];

        if (! in_array($requestBody['userData'], ['1', '2'])) {
            return [
                'message' => 'Invalid Input',
                'status' => 'error',
            ];
        }

        if ($requestBody['userData'] == 1) {
            if ($response = $this->initiateDonationPayment($amount, $requestBody, $event)) {
                $this->saveDonationTransaction($event, $response['Data'], $requestBody['msisdn']);

                return [
                    'message' => 'Kindly accept payment by entering your PIN in the next prompt. You may also dial *170# and select Options 6 and 3',
                    'status' => 'completed',
                ];
            } else {
                return [
                    'message' => 'Payment could not be initiated. Please try again',
                    'status' => 'error',
                ];
            }
        } else {
            return [
                'message' => 'You cancelled the Donation. Please dial again if you want to donate to support us',
                'status' => 'error',
            ];
        }
    }

    private function getCacheKey(array $requestBody): string
    {
        return $requestBody['msisdn'].'|'.$requestBody['sessionID'];
    }

    private function buildMessage(string $message)
    {
        return "Powered by eventsdon.com \n\n".$message;
    }

    private function initiateDonationPayment($amount, array $requestBody, Event $event): mixed
    {
        $response = Http::withBasicAuth(config('ebits.payment.username'), config('ebits.payment.password'))
            ->post(config('ebits.payment.url').'/api/v1/direct-payment/initiate', [
                'customer_name' => $requestBody['msisdn'],
                'customer_msisdn' => $requestBody['msisdn'],
                'customer_email' => 'austy2012@gmail.com',
                'amount' => $amount,
                'channel' => PhoneService::getChannel($requestBody['msisdn']),
                'description' => "Donation of {$requestBody['userData']} for {$event->name}",
                'callback_url' => route('donations.webhook'),
                'merchantAccountNumber' => '2017377',
                'merchant_reference' => Uuid::uuid4(),
            ])->json();

        return $response;
    }

    private function validateDonationAmount(string $amount): ?float
    {
        $amount = filter_var($amount, FILTER_VALIDATE_FLOAT);

        return ($amount !== false && $amount > 0) ? $amount : null;
    }

    private function saveDonationTransaction(Event $event, $responseData, $msisdn): void
    {
        DonationTransaction::create([
            //            'attendee_id' => $attendee->id,
            'amount' => $responseData['Amount'],
            'amount_after_charges' => $responseData['AmountAfterCharges'],
            'transaction_id' => $responseData['TransactionId'],
            'description' => $responseData['Description'],
            'event_id' => $event->id,
            'msisdn' => $msisdn,
            'reference_id' => $responseData['ReferenceId'],
        ]);
    }
}
