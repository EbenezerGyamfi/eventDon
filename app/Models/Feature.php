<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class)->withPivot('value');
    }

    public function planFeatures(): HasMany
    {
        return $this->hasMany(PlanFeature::class);
    }
}
