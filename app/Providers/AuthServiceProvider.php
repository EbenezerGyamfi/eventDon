<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\Event;
use App\Policies\ContactGroupPolicy;
use App\Policies\ContactPolicy;
use App\Policies\EventPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        Contact::class => ContactPolicy::class,
        ContactGroup::class => ContactGroupPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
