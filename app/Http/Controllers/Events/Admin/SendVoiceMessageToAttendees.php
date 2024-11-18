<?php

namespace App\Http\Controllers\Events\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Notifications\SendMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SendVoiceMessageToAttendees extends Controller
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
            'message' => [
                'required',
                'file',
                'mimes:mp3,wav,flac,aac,wma,m4a,ogg',
            ],
        ]);

        $messageFile = $request->file('message');

        $path = $messageFile->storePubliclyAs(
            'voice-messages',
            Carbon::now()->timestamp."voice_message.{$messageFile->extension()}",
            'public'
        );
        $data = ['message' => $path];

        $event = Event::with([
            'attendees',
        ])->find($id);

        Notification::send($event->attendees, new SendMessage($data, 'voice'));

        return back();
    }
}
