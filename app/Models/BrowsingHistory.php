<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrowsingHistory extends Model
{
    protected $fillable = [
        'user_id', 
        'domain', 
        'url', 
        'title', 
        'duration', 
        'timestamp', 
        'scroll_depth', 
        'active_time_ms', 
        'video_time_ms', 
        'search_query',
        'clicks',
        'favicon'
    ];

    protected $casts = [
        'clicks' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
