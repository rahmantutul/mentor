<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrowsingHistory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     */
    public function adminIndex(Request $request)
    {
        $user = Auth::user();
        
        // Paginated Users with Deep Analytics Data
        $users = User::where('is_admin', false)
            ->with(['videoProgress.content'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Aggregate Data for Charts
        $categoryStats = \App\Models\Content::select('category', \DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get();

        $totalViews = \App\Models\UserVideoProgress::count();
        $avgCompletion = \App\Models\UserVideoProgress::avg('completion_percent') ?? 0;
        $totalWatchTime = \App\Models\UserVideoProgress::sum('watched_seconds');
        $uniqueViewers = \App\Models\UserVideoProgress::distinct('user_id')->count();

        // Old Browsing History Stats (Keeping for compatibility)
        $total_records = BrowsingHistory::count();
        $recent_activity = BrowsingHistory::with('user')->orderBy('timestamp', 'desc')->limit(10)->get();

        return view('admin-dashboard', compact(
            'users', 
            'categoryStats', 
            'totalViews', 
            'avgCompletion', 
            'totalWatchTime', 
            'uniqueViewers',
            'total_records',
            'recent_activity'
        ));
    }

    /**
     * Show the user dashboard.
     */
    public function userIndex(Request $request)
    {
        $user = Auth::user();

        // Featured content for hero
        $featured = \App\Models\Content::where('is_featured', true)->latest()->first();

        // Shorts
        $shorts = \App\Models\Content::where('type', 'short')->active()->latest()->limit(12)->get();

        // Videos the user is currently watching (has progress, not completed)
        $continueWatching = $user->videoProgress()
            ->with('content')
            ->where('completed', false)
            ->where('watched_seconds', '>', 0)
            ->orderByDesc('last_watched_at')
            ->limit(10)
            ->get();

        // Personalized feed: match user interests to content categories
        $recommended = \App\Models\Content::forUser($user)
            ->where('type', 'video')
            ->where('is_featured', false)
            ->whereNotIn('id', $user->videoProgress()->pluck('content_id'))
            ->latest()
            ->limit(12)
            ->get();

        // Fallback: if no interests set or no matching content, show latest active
        if ($recommended->isEmpty()) {
            $recommended = \App\Models\Content::where('type', 'video')->where('is_featured', false)->active()->latest()->limit(12)->get();
        }

        // Stats
        $totalWatchSeconds  = $user->totalWatchSeconds();
        $completedCount     = $user->completedVideosCount();
        $inProgressCount    = $user->videoProgress()->where('completed', false)->where('watched_seconds', '>', 0)->count();

        // Extension Metrics
        $latestSnapshot = \App\Models\ExtensionMetricsSnapshot::where('user_id', $user->id)
            ->latest('captured_at')
            ->first();
            
        $focusScore = $latestSnapshot ? $latestSnapshot->focus_score : 0;
        $productivityScore = $latestSnapshot ? $latestSnapshot->productivity_score : 0;
        
        $todayActiveMs = \App\Models\ExtensionSession::where('user_id', $user->id)
            ->whereDate('started_at', today())
            ->sum('active_ms');
        
        $extensionStats = [
            'focus_score' => $focusScore,
            'productivity_score' => $productivityScore,
            'active_hours_today' => round($todayActiveMs / (1000 * 60 * 60), 1)
        ];

        // Learning Activity Chart Data (last 7 days)
        $dailyActivity = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $seconds = $user->videoProgress()
                ->whereDate('updated_at', $date)
                ->sum('watched_seconds'); 
            
            $dailyActivity[] = [
                'day' => now()->subDays($i)->format('D'),
                'minutes' => round($seconds / 60)
            ];
        }

        // Active Courses
        $courses = \App\Models\Course::where('status', 'active')->latest()->limit(8)->get();

        return view('user-dashboard', compact(
            'featured',
            'shorts',
            'continueWatching',
            'recommended',
            'courses',
            'totalWatchSeconds',
            'completedCount',
            'inProgressCount',
            'dailyActivity',
            'extensionStats'
        ));
    }

    public function activityHistory(Request $request)
    {
        $user = Auth::user();
        $query = BrowsingHistory::query()->with('user');

        // Enforcement: Non-admins only see their own data
        if (!$user->is_admin) {
            $query->where('user_id', $user->id);
        } else {
            // Admin filters
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
        }

        // Common filters
        if ($request->filled('domain')) {
            $query->where('domain', $request->domain);
        }

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function($q) use ($s) {
                $q->where('title', 'like', "%$s%")
                  ->orWhere('url', 'like', "%$s%")
                  ->orWhere('domain', 'like', "%$s%")
                  ->orWhere('search_query', 'like', "%$s%");
            });
        }

        // Capture filtered count before pagination
        $filtered_count = $query->count();
        
        // Final results
        $history = $query->orderBy('timestamp', 'desc')->paginate(50)->withQueryString();

        // Data for dropdowns (only non-admins)
        $users = User::where('is_admin', false)->orderBy('name')->get();
        $domains = BrowsingHistory::when(!$user->is_admin, fn($q) => $q->where('user_id', $user->id))
            ->distinct()->pluck('domain')->sort();

        return view('activity-history', compact('history', 'filtered_count', 'users', 'domains'));
    }

    /**
     * Show the extension setup page.
     */
    public function extensionSetup(Request $request)
    {
        $user = Auth::user();
        $devices = \App\Models\ExtensionDevice::where('user_id', $user->id)
            ->whereNull('revoked_at')
            ->orderBy('last_active_at', 'desc')
            ->get();

        return view('extension-setup', compact('devices'));
    }

    /**
     * Show the raw extension data (Sessions and Metrics).
     */
    public function extensionData()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $sessions = \App\Models\ExtensionSession::where('user_id', $user->id)
            ->orderBy('started_at', 'desc')
            ->get();
            
        $snapshots = \App\Models\ExtensionMetricsSnapshot::where('user_id', $user->id)
            ->orderBy('captured_at', 'desc')
            ->get();

        $rollups = \App\Models\ExtensionDailyRollup::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        $recommendations = \App\Models\ExtensionRecommendation::where('user_id', $user->id)
            ->with(['events' => function($q) {
                $q->orderBy('occurred_at', 'desc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('extension-data', compact('sessions', 'snapshots', 'rollups', 'recommendations'));
    }

    /**
     * Delete all extension tracked data (Sessions, Snapshots, Rollups, Recs) for the logged-in user.
     */
    public function resetExtensionData()
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // Delete Recommendation Events
        $recIds = \App\Models\ExtensionRecommendation::where('user_id', $user->id)->pluck('id');
        \App\Models\ExtensionRecommendationEvent::whereIn('ext_recommendation_id', $recIds)->delete();

        // Delete Recommendations
        \App\Models\ExtensionRecommendation::where('user_id', $user->id)->delete();

        // Delete Daily Rollups
        \App\Models\ExtensionDailyRollup::where('user_id', $user->id)->delete();

        // Delete Snapshots
        \App\Models\ExtensionMetricsSnapshot::where('user_id', $user->id)->delete();

        // Delete Sessions
        \App\Models\ExtensionSession::where('user_id', $user->id)->delete();

        return redirect()->route('extension.data')->with('success', 'All browser extension data wiped successfully.');
    }

    public function revokeDevice(\App\Models\ExtensionDevice $device)
    {
        if ($device->user_id !== auth()->id()) {
            abort(403);
        }
        $device->update(['revoked_at' => now()]);
        return response()->json(['data' => ['unlinked' => true]]);
    }
}
