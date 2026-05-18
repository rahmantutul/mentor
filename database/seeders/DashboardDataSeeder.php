<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class DashboardDataSeeder extends Seeder
{
    public function run(): void
    {
        // Set some featured content
        Content::where('category', 'AI & ML')->limit(3)->update(['is_featured' => true]);

        // Set some shorts (videos with short duration or just pick randomly)
        Content::where('duration_seconds', '<', 300)->limit(10)->update(['type' => 'short']);
        
        // Ensure we have at least 6 shorts
        if (Content::where('type', 'short')->count() < 6) {
            Content::limit(6)->update(['type' => 'short']);
        }

        // Set one specifically as the "Main Featured" for the hero
        Content::where('is_featured', true)->first()->update(['title' => 'How to Automate Repetitive Tasks with AI']);
    }
}
