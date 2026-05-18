<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtensionRecommendationEvent extends Model
{
    protected $guarded = [];

    protected $casts = [
        'occurred_at' => 'datetime',
        'context' => 'array',
    ];

    public function recommendation()
    {
        return $this->belongsTo(ExtensionRecommendation::class, 'ext_recommendation_id');
    }
}
