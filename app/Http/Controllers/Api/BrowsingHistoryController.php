<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BrowsingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrowsingHistoryController extends Controller
{
    /**
     * Sync history data from extension.
     */
    public function sync(Request $request)
    {
        $user = $request->user();
        $data = $request->input('history', []);

        if (!$user || empty($data)) {
            return response()->json(['status' => 'success', 'synced' => 0]);
        }

        $upsertData = [];
        foreach ($data as $item) {
            $upsertData[] = [
                'user_id'         => $user->id,
                'domain'          => $item['domain'],
                'url'             => substr($item['url'], 0, 255),
                'title'           => $item['title'] ?? null,
                'duration'        => $item['duration'] ?? 0,
                'timestamp'       => $item['timestamp'],
                'scroll_depth'    => $item['scrollDepth'] ?? 0,
                'active_time_ms'  => $item['activeTimeMs'] ?? 0,
                'video_time_ms'   => $item['videoWatchTimeMs'] ?? 0,
                'search_query'    => $item['searchQuery'] ?? null,
                'clicks'          => json_encode($item['clicks'] ?? []),
                'favicon'         => $item['favicon'] ?? null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        // High-performance batch upsert (single SQL query)
        BrowsingHistory::upsert(
            $upsertData,
            ['user_id', 'url', 'timestamp'], // Unique constraints
            ['domain', 'title', 'duration', 'scroll_depth', 'active_time_ms', 'video_time_ms', 'search_query', 'clicks', 'favicon', 'updated_at']
        );

        return response()->json([
            'status' => 'success',
            'synced' => count($upsertData)
        ]);
    }

    /**
     * Fetch history data for the extension.
     */
    public function fetch(Request $request)
    {
        $user = $request->user();
        $history = BrowsingHistory::where('user_id', $user->id)
            ->orderBy('timestamp', 'desc')
            ->limit(100)
            ->get();

        return response()->json($history);
    }
    /**
     * Clear all history for the user.
     */
    public function clear(Request $request)
    {
        $user = $request->user();
        BrowsingHistory::where('user_id', $user->id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'History cleared'
        ]);
    }
}
