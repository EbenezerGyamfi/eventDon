<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Attendee extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'event_id',
        'contact_id',
        'phone',
        'ussd_session_id',
        'is_present',
        'has_pre_registered',
    ];

    protected $casts = [
        'created_at' => 'immutable_datetime:jS M, Y \a\t h:i A',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function scopeFilter(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($query, $search) {
            return $query->where('phone', 'like', '%'.$search.'%');
        });
    }

    public function scopeIsPresent(Builder $query): Builder
    {
        return $query->where('is_present', true);
    }

    public function scopeHasPreRegistered(Builder $query): Builder
    {
        return $query->where('has_pre_registered', true);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(Gifts::class);
    }

    public function getName()
    {
        $attendeeNameQuestion = $this->answers()->with('question', fn ($query) => $query->where(['title' => 'Name']))->first();

        return ! empty($attendeeNameQuestion) ? $attendeeNameQuestion->answer : '';
    }
}
