<?php

namespace App\Http\Controllers\Events\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Attendee;
use App\Models\Event;
use App\Notifications\SendMessage;
use Illuminate\Http\Request;

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
        $sender = $request->input('sender');

        $results = [];
        preg_match_all('/<([^<]+)>/', $message, $results);
        [, $variables] = $results;

        $event = Event::with([
            'attendees',
            'attendees.answers',
            'attendees.answers.question',
        ])->find($id);

        $event
            ->attendees
            ->each(function (Attendee $attendee) use ($variables, $message, $sender) {
                $attendee
                    ->answers
                    ->each(function (Answer $answer) use (&$message, $variables) {
                        if (in_array(strtolower($answer->question->title), $variables)) {
                            $variable = strtolower($answer->question->title);
                            $message = str_replace("<{$variable}>", $answer->answer, $message);
                        }
                    });
                $message = trim($message);

                $attendee->notify(new SendMessage([
                    'message' => $message,
                    'sender' => $sender,
                ]));
            });

        return back();
    }
}
