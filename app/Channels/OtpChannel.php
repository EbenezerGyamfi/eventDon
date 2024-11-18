<?php

namespace App\Channels;

use App\Notifications\SendOtp;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class OtpChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, SendOtp $notification)
    {
        [
            'message' => $message,
            'sender' => $sender
        ] = $notification->toOtp($notifiable);

        Http::withHeaders([
            'api-key' => config('arkesel.apiKey'),
        ])->post(config('arkesel.apiUrl').'/otp/generate', [
            'sender_id' => $sender,
            'message' => $message,
            'number' => $notifiable->phone,
            'type' => 'numeric',
            'expiry' => 5,
            'length' => 6,
            'medium' => 'sms',
        ]);
    }
}
