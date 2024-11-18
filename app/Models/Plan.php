<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function getFeatureValue(string $name)
    {
        return $this->features()->where('name', $name)->first()?->pivot->value;
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'plan_features')
            ->withPivot('value');
    }
}
