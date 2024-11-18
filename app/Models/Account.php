<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'type', 'account_number', 'details', 'user_id',
    ];

    protected $casts = [
        'details' => 'array',
        'created_at' => 'immutable_datetime:Y-m-d',
    ];

    public function scopeDoesntExist(Builder $query): bool
    {
        return $query->count() === 0;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
