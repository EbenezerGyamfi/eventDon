<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'parent',
        'phone_number_verified',
        'assigned_to',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $appends = ['avatarUrl'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIsAdminAttribute(): bool
    {
        return $this->role === 'admin';
    }

    public function getIsTellerAttribute(): bool
    {
        return in_array($this->role, [
            'teller', 'client_admin',
        ]);
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar
        ? Storage::disk('public')->url($this->avatar)
        : null;
    }

    public function getEmailVerifiedAttribute(): bool
    {
        return ! is_null($this->email_verified_at);
    }

    public function scopeDoesntExist(Builder $query): bool
    {
        return $query->count() === 0;
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function walletEvents(): HasManyThrough
    {
        return $this->hasManyThrough(WalletEvent::class, Wallet::class);
    }

    public function mainWallet(): HasOne
    {
        return $this->hasOne(Wallet::class)->oldestOfMany();
    }

    public function contactGroups(): HasMany
    {
        return $this->hasMany(ContactGroup::class);
    }

    public function tellers(): HasMany
    {
        return $this->hasMany(User::class, 'parent')
            ->where('role', 'teller');
    }

    public function assignedEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_tellers');
    }

    public function gifts()
    {
        return $this->belongsToMany(Gifts::class, 'gifts');
    }
}
