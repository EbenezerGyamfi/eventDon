<?php

namespace App\Http\Controllers\Events\Client;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletEvent;
use App\Notifications\SendMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

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

        $ffprobe = \FFMpeg\FFProbe::create([
            'ffmpeg.binaries' => config('laravel_ffmpeg.ffmpeg'),
            'ffprobe.binaries' => config('laravel_ffmpeg.ffprobe'),
        ]);

        $voiceMessage = $request->file('message');

        $audio_duration = $ffprobe->format($voiceMessage)->get('duration');

        $event = Event::with([
            'attendees',
        ])->find($id);

        $numberOffAttendees = count($event->attendees);

        $wallet = auth()->user()->mainWallet;

        $voiceMessageCost = 0;

        if ($audio_duration < 60) {
            $voiceMessageCost = (config('eventsdon.voiceMessageCost') / (60 / $audio_duration)) * $numberOffAttendees;
        } else {
            $voiceMessageCost = (($audio_duration / 60) * config('eventsdon.voiceMessageCost')) * $numberOffAttendees;
        }

        if ($wallet->balance < $voiceMessageCost) {
            return back()->withErrors(['error' => 'Insufficient Balance, kindly topup']);
        } else {
            WalletEvent::create([
                'wallet_id' => $wallet->id,
                'before_balance' => $wallet->balance,
                'after_balance' => $wallet->balance - $voiceMessageCost,
                'transaction_amount' => $voiceMessageCost,
                'type' => 'debited',
                'description' => 'Sent a voice message',

            ]);

            Wallet::where('id', $wallet->id)->update([
                'balance' => $wallet->balance - $voiceMessageCost,
            ]);

            $refrence = Str::random(12);

            while (! Transaction::where('reference', $refrence)->doesntExist()) {
                $refrence = Str::random(12);
            }

            Transaction::create([
                'reference' => $refrence,
                'amount' => $voiceMessageCost,
                'wallet_id' => $wallet->id,
                'user_id' => auth()->id(),
                'description' => 'Paid for voice SMS sent to event attendees',
            ]);

            $path = $voiceMessage->storePubliclyAs(
                'voice-messages',
                Carbon::now()->timestamp."voice_message.{$voiceMessage->extension()}",
                'public'
            );
            $data = ['message' => $path];

            Notification::send($event->attendees, new SendMessage($data, 'voice'));

            return back()->with('message', 'Voice SMS sent');
        }
    }
}
