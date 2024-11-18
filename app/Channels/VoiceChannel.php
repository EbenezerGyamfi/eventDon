<?php

namespace App\Channels;

use App\Notifications\SendMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class VoiceChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, SendMessage $notification)
    {
        [
            'message' => $message,
        ] = $notification->toVoice($notifiable);

        $name = substr($message, strrpos($message, '/') + 1);
        $file = Storage::disk('public')->get($message);

        Http::attach(name: 'voice_file', contents: $file, filename: $name)
            ->withHeaders([
                'api-key' => config('arkesel.apiKey'),
            ])
            ->post(config('arkesel.apiUrl').'/v2/sms/voice/send', [
                'recipients[]' => $notifiable->phone,
            ]);
    }
}
