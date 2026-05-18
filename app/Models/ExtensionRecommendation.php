<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtensionRecommendation extends Model
{
    protected $guarded = [];

    protected $casts = [
        'current_context' => 'array',
        'recent_behavior' => 'array',
        'local_signals' => 'array',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function events()
    {
        return $this->hasMany(ExtensionRecommendationEvent::class, 'ext_recommendation_id');
    }
}
