<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $notificationData = $notification->toSms($notifiable);

        $res = Http::withHeaders([
            'api-key' => config('arkesel.apiKey'),
        ])->post(
            config('arkesel.apiUrl').'/v2/sms/send',
            array_merge($notificationData, [
                'recipients' => [
                    $notifiable->phone,
                ],
                'sandbox' => config('arkesel.sandbox'),
            ])
        );

        $json = $res->json();
        $data = $json['data'];

        // Update SMS campaign
        if (
            ! is_null($notifiable->sms_campaign_id) ||
            ! is_null($notifiable->event_id)
        ) {
            if ($res->status() === 200) {
                $notifiable->update(['sms_id' => $data[0]['id']]);
            }
        }
    }
}
