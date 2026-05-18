<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtensionDailyRollup extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'top_platforms' => 'array',
        'top_ai_tools' => 'array',
        'student_learning_needs' => 'array',
    ];
}
