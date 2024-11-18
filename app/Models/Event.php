<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ussd_extension_id',
        'contact_group_id',
        'plan_id',
        'name',
        'description',
        'type',
        'venue',
        'start_time',
        'end_time',
        'expected_attendees',
        'greeting_message',
        'goodbye_message',
        'program_lineup',
        'pre_registration_ussd_extension_id',
        'pre_registration_start_time',
        'pre_registration_end_time',
        'can_pre_register',
        'ask_pre_registration_questions',
        'ticketing_ussd_extension_id',
        'ticketing',
        'ticket_price',
        'no_of_available_tickets',
        'ticketing_start_time',
        'ticketing_end_time',
    ];

    protected $casts = [
        'start_time' => 'immutable_datetime:Y-m-d H:i:s',
        'end_time' => 'immutable_datetime:Y-m-d H:i:s',
        'created_at' => 'immutable_datetime:Y-m-d',
    ];

    protected $appends = [
        'status',
    ];

    protected $hidden = [
        'description',
        'updated_at',
    ];

    public function getStatusAttribute(): string
    {
        return $this->end_time?->isPast()
            ? 'completed'
            : ($this->start_time?->isFuture() ? 'upcoming' : 'ongoing');
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('start_time', '>', Carbon::now());
    }

    public function scopeOngoing(Builder $query): Builder
    {
        return $query->where('start_time', '<=', Carbon::now())
            ->where('end_time', '>=', Carbon::now());
    }

    public function scopeBeforeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', '<', Carbon::now());
    }

    public function scopeWasOngoingAnHourAgo(Builder $query): Builder
    {
        return $query->where('start_time', '<', Carbon::now()->subHour())
            ->where('end_time', '<', Carbon::now()->subHour());
    }

    public function scopeFirstForUsers(Builder $query): Builder
    {
        return $query->whereHas('user.events', fn ($query) => $query, '=', 1);
    }

    public function scopeFilter(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($query, $search) {
            return $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('venue', 'like', '%'.$search.'%');
        });
    }

    public function scopeNotInPeriod(Builder $query, string $startTime, string $endTime): Builder
    {
        return $query->whereNotBetween('start_time', [Carbon::parse($startTime), Carbon::parse($endTime)])
            ->whereNotBetween('end_time', [Carbon::parse($startTime), Carbon::parse($endTime)]);
    }

    public function scopeInPeriod(Builder $query, string $startTime, string $endTime): Builder
    {
        return $query->whereBetween('start_time', [Carbon::parse($startTime), Carbon::parse($endTime)])
            ->orWhereBetween('end_time', [Carbon::parse($startTime), Carbon::parse($endTime)]);
    }

    public function scopeIsInPreRegistration(Builder $query): Builder
    {
        return $query->where('pre_registration_start_time', '<=', Carbon::now())
            ->where('pre_registration_end_time', '>=', Carbon::now());
    }

    public function scopeIsInTicketing(Builder $query): Builder
    {
        return $query->where('ticketing_start_time', '<=', Carbon::now())
            ->where('ticketing_end_time', '>=', Carbon::now());
    }

    public function scopeIsInPreRegistrationBetween(Builder $query, string $startTime, string $endTime): Builder
    {
        return $query->whereBetween(
            'pre_registration_start_time',
            [Carbon::parse($startTime), Carbon::parse($endTime)]
        )
            ->orWhereBetween(
                'pre_registration_end_time',
                [Carbon::parse($startTime), Carbon::parse($endTime)]
            );
    }

    public function scopeIsInTicketingBetween(Builder $query, string $startTime, string $endTime): Builder
    {
        return $query->whereBetween(
            'ticketing_start_time',
            [Carbon::parse($startTime), Carbon::parse($endTime)]
        )
            ->orWhereBetween(
                'ticketing_end_time',
                [Carbon::parse($startTime), Carbon::parse($endTime)]
            );
    }

    public function inPreRegistration(): bool
    {
        if (
            $this->pre_registration_start_time <= now() &&
            $this->pre_registration_end_time >= now()
        ) {
            return true;
        }

        return false;
    }

    public function shouldChangeAttendanceUssdExtension($newStartTime, $newEndTime)
    {
        return UssdExtension::query()
            ->whereDoesntHave('events', function ($query) use ($newStartTime, $newEndTime) {
                return $query->whereNotIn('id', [$this->id])
                    ->InPeriod($newStartTime, $newEndTime);
            })
            ->where('id', $this->ussd_extension_id)
            ->where('type', UssdExtension::$ATTENDACE)
            ->count() != 1;
    }

    public function shouldChangeTicketingUssdExtension($newStartTime, $newEndTime)
    {
        return UssdExtension::query()
            ->whereDoesntHave('ticketingEvents', function ($query) use ($newStartTime, $newEndTime) {
                return $query->whereNotIn('id', [$this->id])
                    ->IsInTicketingBetween($newStartTime, $newEndTime);
            })
            ->where('id', $this->ussd_extension_id)
            ->where('type', UssdExtension::$TICKETING)
            ->count() != 1;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tellers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_tellers')->withTimestamps();
    }

    public function ussdExtension(): BelongsTo
    {
        return $this->belongsTo(UssdExtension::class);
    }

    public function preRegistrationUssdExtension(): BelongsTo
    {
        return $this->belongsTo(
            UssdExtension::class,
            'pre_registration_ussd_extension_id'
        );
    }

    public function ticketingUssdExtension(): BelongsTo
    {
        return $this->belongsTo(
            UssdExtension::class,
            'ticketing_ussd_extension_id'
        );
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)
            ->where('pre_registration', false);
    }

    public function preRegistrationQuestions(): HasMany
    {
        return $this->hasMany(Question::class)
            ->where('pre_registration', true);
    }

    public function answers()
    {
        return $this->hasManyThrough(Answer::class, Question::class);
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }

    public function preRegisteredAttendees(): HasMany
    {
        return $this->hasMany(Attendee::class)
            ->where('has_pre_registered', true);
    }

    public function contactGroup(): BelongsTo
    {
        return $this->belongsTo(ContactGroup::class);
    }

    public function smsCampaign(): HasMany
    {
        return $this->hasMany(SmsCampaign::class);
    }

    public function smsHistories(): HasMany
    {
        return $this->hasMany(SmsHistory::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(Gifts::class);
    }

    public function giftsEntriesCount(): int
    {
        return $this->gifts()->count('id');
    }

    public function giftsCount(): int
    {
        return $this->gifts()->sum('quantity');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class, 'event_id', 'id');
    }

    public function guestTable(): HasOne
    {
//        return $this->hasOne (EventGuestTable::class);
    }

    public function donationTransactions(): HasMany
    {
        return $this->hasMany(DonationTransaction::class, 'event_id');
    }
}
