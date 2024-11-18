<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\Guest;
use App\Notifications\SendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyGuestsViaSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Guest $guest, public Event $event)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = "Hello {$this->guest->name}, you are invited to {$this->event->name}";
        if (! empty($this->guest->assigned_table_number)) {
            $message .= " Your have been assigned Table {$this->guest->assigned_table_number}";
        }
        $message .= '. Thank you and we hope to see you there!';

        $this->guest->notify(new SendMessage([
            'message' => $message,
            'sender' => config('app.sender'),
        ]));
    }
}
