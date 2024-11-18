<?php

namespace App\Providers;

use App\Events\PaymentSuccessful;
use App\Listeners\DumpBusyQueueInformation;
use App\Listeners\SendOtpNotification;
use App\Listeners\UpdateWalletListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Queue\Events\QueueBusy;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Verified::class => [
            SendOtpNotification::class,
        ],
        PaymentSuccessful::class => [
            UpdateWalletListener::class,
        ],
        QueueBusy::class => [
            DumpBusyQueueInformation::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
