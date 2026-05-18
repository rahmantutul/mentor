<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Toggle bookmark for a content.
     */
    public function toggle(Content $content)
    {
        $user = Auth::user();
        
        if ($user->bookmarkedContents()->where('content_id', $content->id)->exists()) {
            $user->bookmarkedContents()->detach($content->id);
            $status = 'removed';
        } else {
            $user->bookmarkedContents()->attach($content->id);
            $status = 'added';
        }

        $user->recordActivity();

        return response()->json([
            'status' => $status,
            'message' => $status === 'added' ? 'Added to bookmarks' : 'Removed from bookmarks'
        ]);
    }

    /**
     * Display bookmarked contents.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->bookmarkedContents()->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        $bookmarks = $query->paginate(12);
        return view('bookmarks', compact('bookmarks'));
    }
}
