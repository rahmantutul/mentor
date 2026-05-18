<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use App\Models\UserVideoProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the in-platform video player for a given content.
     */
    public function watch(Content $content)
    {
        $user = Auth::user();

        // Get or create progress record
        $progress = UserVideoProgress::firstOrCreate(
            ['user_id' => $user->id, 'content_id' => $content->id],
            ['watched_seconds' => 0, 'duration_seconds' => $content->duration_seconds, 'completion_percent' => 0]
        );

        // If part of a course, get course context
        $course = null;
        if ($content->course_id) {
            $course = $content->course()->with('contents')->first();
        }

        // Recommended videos
        $recommended = collect();
        if (!$course) {
            $watchedIds = $user->videoProgress()->pluck('content_id');
            $recommended = Content::active()
                ->where('category', $content->category)
                ->where('id', '!=', $content->id)
                ->whereNotIn('id', $watchedIds)
                ->limit(5)
                ->get();

            if ($recommended->isEmpty()) {
                $recommended = Content::active()
                    ->where('id', '!=', $content->id)
                    ->inRandomOrder()
                    ->limit(5)
                    ->get();
            }
        }

        return view('learn.watch', compact('content', 'progress', 'recommended', 'course'));
    }

    /**
     * Show Course detail and curriculum.
     */
    public function courseView(Course $course)
    {
        $course->load('contents');
        return view('learn.course-view', compact('course'));
    }

    /**
     * Save video progress via AJAX (called by the YouTube IFrame API).
     */
    public function saveProgress(Request $request)
    {
        $request->validate([
            'content_id'      => 'required|exists:contents,id',
            'watched_seconds' => 'required|integer|min:0',
            'duration_seconds'=> 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $watched  = (int) $request->watched_seconds;
        $duration = (int) $request->duration_seconds;
        $percent  = min(100, round(($watched / $duration) * 100, 2));
        $completed = $percent >= 90; // ≥90% counts as completed

        UserVideoProgress::updateOrCreate(
            ['user_id' => $user->id, 'content_id' => $request->content_id],
            [
                'watched_seconds'  => $watched,
                'duration_seconds' => $duration,
                'completion_percent' => $percent,
                'completed'        => $completed,
                'last_watched_at'  => now(),
            ]
        );

        $user->recordActivity();

        return response()->json(['status' => 'ok', 'completion_percent' => $percent]);
    }

    /**
     * Browse all content (explore page) - filtered by user interests by default.
     */
    public function explore(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'video'); // default to videos
        
        // 1. Get Recommendations (Always based on type 'video' for better focus)
        $interests = $user->interests ?? [];
        $recommendedItems = Content::active()
            ->where(function($q) use ($interests) {
                if (!empty($interests)) {
                    $q->whereIn('category', (array)$interests);
                }
            })
            ->whereNotIn('id', $user->videoProgress()->pluck('content_id'))
            ->inRandomOrder()
            ->limit(4)
            ->get();

        if ($recommendedItems->isEmpty()) {
            $recommendedItems = Content::active()->inRandomOrder()->limit(4)->get();
        }

        // 2. All Items (Filtered and Paginated)
        $query = ($type === 'course') ? Course::where('status', 'active') : Content::active();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('level') && $type === 'video') {
            $query->where('skill_level', $request->level);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%$s%")
                  ->orWhere('description', 'like', "%$s%")
                  ->orWhere('connected_tools', 'like', "%$s%")
                  ->orWhere('tags', 'like', "%$s%");
            });
        }

        $items = $query->latest()->paginate(16)->withQueryString();
        $categories = Content::active()->distinct()->pluck('category')->sort()->values();

        return view('learn.explore', compact('items', 'categories', 'type', 'recommendedItems'));
    }
}
