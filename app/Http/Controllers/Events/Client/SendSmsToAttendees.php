<?php

namespace App\Http\Controllers\Events\Client;

use App\Exceptions\InsufficientBalanceException;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Event;
use App\Models\SmsCampaign;
use App\Notifications\SendMessage;
use App\Support\Users\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SendSmsToAttendees extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, int $id)
    {
        $request->validate([
            'sender' => ['required', 'max:11'],
            'message' => ['required'],
        ]);

        $message = $request->input('message');

        // TODO: Limit SMS messages to
        // number of attendees allowed by the event's plan
        $event = Event::with([
            'attendees' => function ($query) use ($request) {
                $request->boolean('pre_registered')
                    ? $query->hasPreRegistered()
                    : $query->isPresent();
            },
            'attendees.answers',
            'attendees.answers.question',
            'plan',
        ])
            ->withCount('smsHistories')
            ->find($id);

        $attendees = $event->attendees;

        if (! $attendees->count()) {
            return back()->withErrors(['error' => 'This event does not have any attendees yet.']);
        }

        $totalCost = 0;

        $user = auth()->user();

        $results = [];
        preg_match_all('/<([^<]+)>/', $message, $results);
        [, $variables] = $results;

        $data = $attendees->map(function ($attendee) use ($request, $event, $message, $variables, &$totalCost) {
            $now = now();

            $attendee
                ->answers
                ->each(function (Answer $answer) use (&$message, $variables) {
                    if (in_array(strtolower($answer->question?->title), $variables)) {
                        $variable = strtolower($answer->question->title);
                        $message = str_replace("<{$variable}>", $answer->answer, $message);
                    }
                });

            $message = trim($message);

            $cost = ceil(strlen($message) / 160) * config('eventsdon.smsCost');

            $totalCost += $cost;

            return [
                'user_id' => auth()->id(),
                'event_id' => $event->id,
                'sender' => $request->input('sender'),
                'message' => $message,
                'phone' => $attendee->phone,
                'status' => 'IN PROGRESS',
                'cost' => $cost,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        });

        try {
            $this->chargeUser($event, $data->count());

            $campaign = SmsCampaign::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'status' => 'IN PROGRESS',
                'sender' => $request->input('sender'),
                'total_delivered' => 0,
                'cost' => $totalCost,
                'number_of_recipients' => $attendees->count(),
            ]);

            $campaign->smsHistories()->createMany($data);

            foreach ($campaign->smsHistories as $sms) {

                // send the sms
                $sms->notify(new SendMessage([
                    'sender' => $sms->sender,
                    'message' => $sms->message,
                    'callback_url' => route('sms_histories.webhook'),
                ]));
            }

            return back()->with('message', 'SMS sent successfully');
        } catch (InsufficientBalanceException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            report($e);

            $message = 'An error occured please contact support';

            return back()->withErrors(['error' => $message]);
        }
    }

    private function chargeUser(Event $event, int $smsCount)
    {
        $usedSmsCredits = $event->sms_histories_count;

        $allocatedSmsCredits = $event->plan->getFeatureValue('sms_credits');

        $remainingSmsCredits = $allocatedSmsCredits - $usedSmsCredits > 0
            ? $allocatedSmsCredits - $usedSmsCredits
            : 0;

        $shouldChargeWallet = false;

        $amountToChargeWallet = 0;

        $amountToTopUp = 0;

        if (($usedSmsCredits + $smsCount) > $allocatedSmsCredits) {
            $shouldChargeWallet = true;

            $amountToChargeWallet = (($smsCount - $remainingSmsCredits) * config('eventsdon.smsCost'));
        }

        if ($shouldChargeWallet) {
            $userService = new UserService;

            $wallet = auth()->user()->mainWallet;

            if ($wallet->balance < $amountToChargeWallet) {
                $amountToTopUp = $amountToChargeWallet - $wallet->balance;
                throw new InsufficientBalanceException('Insufficient Balance, kindly topup with GHC'.$amountToTopUp);
            }

            DB::transaction(function () use ($userService, $amountToChargeWallet, $event) {
                $userService->chargeWallet($amountToChargeWallet, 'Sent an SMS to '.$event->name.' attendees');
            });
        }

        return $amountToTopUp;
    }
}
