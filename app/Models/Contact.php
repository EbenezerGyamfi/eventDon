<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_group_id',
        'name',
        'phone',
        'email',
        'extra_fields',
    ];

    protected $casts = [
        'extra_fields' => 'array',
    ];

    public function contactGroup(): BelongsTo
    {
        return $this->belongsTo(ContactGroup::class);
    }
}
