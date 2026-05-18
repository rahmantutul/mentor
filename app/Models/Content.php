<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title',
        'type',
        'video_url',
        'duration_seconds',
        'thumbnail',
        'description',
        'tags',
        'category',
        'skill_level',
        'status',
        'is_featured',
        'course_id',
        'section_part_label',
        'sort_order',
        'connected_tools',
    ];

    protected $casts = [
        'duration_seconds' => 'integer',
        'connected_tools' => 'array',
    ];

    // ── Accessors ──────────────────────────────────────────────

    /**
     * Extract YouTube video ID from any YouTube URL format.
     */
    public function getYoutubeIdAttribute(): ?string
    {
        preg_match(
            '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
            $this->video_url,
            $match
        );
        return $match[1] ?? null;
    }

    /**
     * Return the best available thumbnail URL.
     */
    public function getThumbnailUrlAttribute(): string
    {
        // 1. If explicit thumbnail is set, use it
        if ($this->thumbnail && !str_contains($this->thumbnail, 'broken')) return $this->thumbnail;

        // 2. If it's a YouTube video, get the HQ thumbnail
        if ($this->youtube_id) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/maxresdefault.jpg";
        }

        // 3. Last resort fallback
        return 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=800&q=80';
    }

    /**
     * Format duration_seconds into "Xh Ym" or "Zm" string.
     */
    public function getDurationLabelAttribute(): string
    {
        $s = $this->duration_seconds;
        if ($s <= 0) return '';
        $h = floor($s / 3600);
        $m = floor(($s % 3600) / 60);
        if ($h > 0) return "{$h}h {$m}m";
        return "{$m}m";
    }

    // ── Relationships ──────────────────────────────────────────

    public function watchers()
    {
        return $this->belongsToMany(User::class, 'user_video_progress')
            ->withPivot(['watched_seconds', 'completion_percent', 'completed', 'last_watched_at'])
            ->withTimestamps();
    }

    public function bookmarkers()
    {
        return $this->belongsToMany(User::class, 'bookmarks')
            ->withTimestamps();
    }

    public function progressRecords()
    {
        return $this->hasMany(UserVideoProgress::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // ── Scopes ─────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForUser($query, User $user)
    {
        $interests = $user->interests ?? [];
        if (empty($interests)) return $query->active();

        return $query->active()->where(function ($q) use ($interests) {
            foreach ($interests as $interest) {
                $q->orWhere('category', 'like', "%{$interest}%")
                  ->orWhere('tags', 'like', "%{$interest}%");
            }
        });
    }
}
