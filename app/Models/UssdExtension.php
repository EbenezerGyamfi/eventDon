<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UssdExtension extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
    ];

    public static $ATTENDACE = 'attendance';

    public static $REGISTRATION = 'pre-registration';

    public static $TICKETING = 'ticketing';

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function preRegisteredEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'pre_registration_ussd_extension_id')
            ->where('can_pre_register', true);
    }

    public function ticketingEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'ticketing_ussd_extension_id')
            ->where('ticketing', true);
    }

    public function scopeFilter(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($query, $search) {
            return $query->where('code', 'like', '%'.$search.'%');
        });
    }

    public function scopeIsAvailable(Builder $query, $start_time, $end_time): Builder
    {
        return $query->where('type', UssdExtension::$ATTENDACE)
            ->whereDoesntHave(
                'events',
                fn ($query) => $query->inPeriod($start_time, $end_time)
            );
    }

    public function scopeIsAvailableForPreRegistration(Builder $query, string $start_time, $end_time): Builder
    {
        return $query->where('type', UssdExtension::$REGISTRATION)
            ->whereDoesntHave(
                'preRegisteredEvents',
                fn ($query) => $query->isInPreRegistrationBetween($start_time, $end_time)
            );
    }

    public function scopeIsAvailableForTicketing(Builder $query, string $start_time, $end_time): Builder
    {
        return $query->where('type', UssdExtension::$TICKETING)
            ->whereDoesntHave(
                'ticketingEvents',
                fn ($query) => $query->isInTicketingBetween($start_time, $end_time)
            );
    }

    public function getAvailableExtension(string $start_time, string $end_time): ?UssdExtension
    {

        // We set the end time to the end of the day because there can be events
        // that start after this event's start time but end after this event's end time
        // We also subtract 2 hours from the start time to make sure that there is no event that
        // starts 2 hours before this event
        $ussdExtensions = $this->isAvailable(
            Carbon::parse($start_time)->subHours(2),
            Carbon::parse($end_time)->endOfDay()
        )->get();
        $ussdExtension = null;

        if (! is_null($ussdExtensions)) {
            // Some events might start before the event being created
            // and end after the event being created
            // Eg. Event 1 => start_time : 2022-03-15 15:43:00, end_time :2022-03-22 01:21:00
            // event being created => start_time : 2022-03-16 11:21:00, end-time:2022-03-16 16:26:00
            // in such a situation the same ussd extension can't be used
            $availableUssdExtensions = $ussdExtensions->filter(function ($ussdExtension) use ($start_time, $end_time) {
                $inUse = Event::where('start_time', '<', $start_time)
                    ->where('end_time', '>', $end_time)
                    ->where('ussd_extension_id', $ussdExtension->id)
                    ->exists();

                return ! $inUse;
            });

            if ($availableUssdExtensions->count()) {
                $ussdExtension = $availableUssdExtensions->first();
            }
        }

        return $ussdExtension;
    }

    public function getAvailableExtensionForPreRegistration(string $start_time, string $end_time): ?UssdExtension
    {
        $ussdExtensions = $this->isAvailableForPreRegistration(
            Carbon::parse($start_time),
            Carbon::parse($end_time)->endOfDay()
        )->get();

        $ussdExtension = null;

        if (! is_null($ussdExtensions)) {
            $availableUssdExtensions = $ussdExtensions->filter(function ($ussdExtension) use ($start_time, $end_time) {
                $inUse = Event::where('pre_registration_start_time', '<', $start_time)
                    ->where('pre_registration_end_time', '>', $end_time)
                    ->where('pre_registration_ussd_extension_id', $ussdExtension->id)
                    ->exists();

                return ! $inUse;
            });

            if ($availableUssdExtensions->count()) {
                $ussdExtension = $availableUssdExtensions->first();
            }
        }

        return $ussdExtension;
    }

    public function getAvailableExtensionForTicketing(
        string $start_time,
        string $end_time,
    ): ?UssdExtension {
        $ussdExtensions = $this->isAvailableForTicketing(
            Carbon::parse($start_time),
            Carbon::parse($end_time)->endOfDay()
        )->get();

        $ussdExtension = null;

        if (! is_null($ussdExtensions)) {
            $availableUssdExtensions = $ussdExtensions->filter(function ($ussdExtension) use ($start_time, $end_time) {
                $inUse = Event::where('ticketing_start_time', '<', $start_time)
                    ->where('ticketing_end_time', '>', $end_time)
                    ->where('ticketing_ussd_extension_id', $ussdExtension->id)
                    ->exists();

                return ! $inUse;
            });

            if ($availableUssdExtensions->count()) {
                $ussdExtension = $availableUssdExtensions->first();
            }
        }

        return $ussdExtension;
    }
}
