<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendee_id',
        'question_id',
        'answer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
