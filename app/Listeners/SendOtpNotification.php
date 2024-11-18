<?php

namespace App\Listeners;

use App\Notifications\SendOtp;
use Illuminate\Auth\Events\Verified;

class SendOtpNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $event->user->notify(new SendOtp);
    }
}
