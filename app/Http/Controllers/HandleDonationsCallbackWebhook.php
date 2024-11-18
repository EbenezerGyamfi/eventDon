<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationTransaction;
use App\Notifications\SendMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HandleDonationsCallbackWebhook extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $transaction = DonationTransaction::where(['reference_id' => $request->reference_id])->first();

        try {
            DB::transaction(function () use ($transaction, $request) {
                $statusMessage = $request->meta_data['Description'] ?? '';
                $transaction->update([
                    'status' => $request->status,
                    'status_message' => $statusMessage,
                ]);

                $phone = ! empty($transaction->attendee) ? $transaction->attendee?->phone : $transaction->msisdn;
                $name = ! empty($transaction->attendee) ? $transaction->attendee?->answers()?->first()?->answer : $phone;

                if ($request->status === 'success') {
                    if (Donation::create([
                        'name' => $name,
                        'phone' => $phone,
                        'event_id' => $transaction->event_id,
                        'amount' => $request->amount,
                        'type' => 'ussd',
                        'attendee_id' => $transaction->attendee_id,
                    ])) {
                        $message = 'Thank you for your cash donation of GH¢'.number_format($request->amount, 2).' towards our event. May God richly bless you';
                        if (! empty($transaction->attendee)) {
                            $transaction->attendee->notify(new SendMessage([
                                'message' => $message,
                                'sender' => config('app.sender'),
                            ]));
                        } else {
                            Http::withHeaders([
                                'api-key' => config('arkesel.apiKey'),
                            ])->post(
                                config('arkesel.apiUrl').'/v2/sms/send', [
                                    'recipients' => [$phone],
                                    'sender' => config('app.sender'),
                                    'sandbox' => config('arkesel.sandbox'),
                                    'message' => $message,
                                ]
                            );
                        }
                    }
                }
            });
        } catch (\Exception $e) {
            \Log::error("------ DONATIONS::Failed to Update Donation Transaction[{$transaction->id}] and Donation. Message: {$e->getMessage()} ------", [
                'data' => $request->all(),
            ]);
        }

        return response()->noContent();
    }
}
