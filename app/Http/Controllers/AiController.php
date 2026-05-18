<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class AiController extends Controller
{
    /**
     * Show the AI Mentor chat page with database video suggestions.
     */
    public function index()
    {
        // Fetch real videos from database to show in the chat as suggestions
        $suggestedVideos = Content::where('type', 'video')
            ->active()
            ->latest()
            ->limit(10)
            ->get();
            
        return view('ask-ai', compact('suggestedVideos'));
    }
}
