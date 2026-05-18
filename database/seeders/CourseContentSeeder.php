<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Content;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class CourseContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data to avoid conflicts
        Schema::disableForeignKeyConstraints();
        Content::truncate();
        Course::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Create Courses
        $course1 = Course::create([
            'title' => 'AI-Powered Marketing Mastery',
            'description' => 'Learn how to leverage generative AI to automate your marketing workflows, create high-converting copy, and analyze data like a pro.',
            'category' => 'Marketing',
            'status' => 'active',
            'thumbnail' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&q=80',
        ]);

        $course2 = Course::create([
            'title' => 'Mastering ChatGPT for Business',
            'description' => 'A comprehensive guide to using ChatGPT for business productivity, from advanced prompt engineering to custom GPT creation.',
            'category' => 'Productivity',
            'status' => 'active',
            'thumbnail' => 'https://images.unsplash.com/photo-1675557009875-436f09789452?w=800&q=80',
        ]);

        // 2. Add Videos to Course 1
        Content::create([
            'title' => 'The AI Marketing Revolution',
            'slug' => Str::slug('The AI Marketing Revolution'),
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=R9OHn5ZF4Uo',
            'category' => 'Marketing',
            'skill_level' => 'Beginner',
            'status' => 'active',
            'course_id' => $course1->id,
            'section_part_label' => 'Introduction',
            'sort_order' => 1,
            'description' => 'An overview of how AI is transforming the marketing industry.',
            'tags' => 'ai, marketing, automation',
        ]);

        Content::create([
            'title' => 'Automating Content Strategy',
            'slug' => Str::slug('Automating Content Strategy'),
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=S37x2VS07yU',
            'category' => 'Marketing',
            'skill_level' => 'Intermediate',
            'status' => 'active',
            'course_id' => $course1->id,
            'section_part_label' => 'Introduction',
            'sort_order' => 2,
            'description' => 'How to use AI to generate content pillars and social media calendars.',
            'tags' => 'strategy, content, ai',
        ]);

        Content::create([
            'title' => 'Data Analysis with AI Tools',
            'slug' => Str::slug('Data Analysis with AI Tools'),
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=fS_6ZghZfio',
            'category' => 'Marketing',
            'skill_level' => 'Advanced',
            'status' => 'active',
            'course_id' => $course1->id,
            'section_part_label' => 'Advanced Techniques',
            'sort_order' => 1,
            'description' => 'Deep dive into using AI for predictive marketing analytics.',
            'tags' => 'data, analytics, advanced',
        ]);

        // 3. Add Videos to Course 2
        Content::create([
            'title' => 'Prompt Engineering 101',
            'slug' => Str::slug('Prompt Engineering 101'),
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=jC4v5AS4RIM',
            'category' => 'Productivity',
            'skill_level' => 'Beginner',
            'status' => 'active',
            'course_id' => $course2->id,
            'section_part_label' => 'The Basics',
            'sort_order' => 1,
            'description' => 'Learn the core principles of effective prompt engineering.',
            'tags' => 'chatgpt, prompts, basics',
        ]);

        Content::create([
            'title' => 'Building Custom GPTs',
            'slug' => Str::slug('Building Custom GPTs'),
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=uXp_Y62EebY',
            'category' => 'Productivity',
            'skill_level' => 'Intermediate',
            'status' => 'active',
            'course_id' => $course2->id,
            'section_part_label' => 'Customization',
            'sort_order' => 1,
            'description' => 'Step-by-step guide to building your own custom AI assistants.',
            'tags' => 'gpts, custom, productivity',
        ]);

        // 4. Standalone Individual Videos
        Content::create([
            'title' => '10 Mind-Blowing AI Tools for 2026',
            'slug' => Str::slug('10 Mind-Blowing AI Tools for 2026'),
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=mE9pDCHM_T0',
            'category' => 'Technology',
            'skill_level' => 'Beginner',
            'status' => 'active',
            'course_id' => null,
            'description' => 'A curated list of the most impactful AI tools released this year.',
            'tags' => 'ai tools, technology, trends',
        ]);

        Content::create([
            'title' => 'The Ethics of Generative AI',
            'slug' => Str::slug('The Ethics of Generative AI'),
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=Nn_vX_Y3_8k',
            'category' => 'Society',
            'skill_level' => 'Intermediate',
            'status' => 'active',
            'course_id' => null,
            'description' => 'Discussing the philosophical and ethical implications of AI creativity.',
            'tags' => 'ethics, ai, philosophy',
        ]);

        // 5. Individual Series (Grouping without a Course)
        Content::create([
            'title' => 'Morning Rituals for High Performance',
            'slug' => Str::slug('Morning Rituals for High Performance'),
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=0W8fC2Lz5_Y',
            'category' => 'Productivity',
            'skill_level' => 'Beginner',
            'status' => 'active',
            'course_id' => null,
            'section_part_label' => 'Daily Performance Series',
            'sort_order' => 1,
            'description' => 'Part 1: Setting up your day for maximum AI productivity.',
            'tags' => 'morning, performance, series',
        ]);

        Content::create([
            'title' => 'Deep Work in the Age of AI',
            'slug' => Str::slug('Deep Work in the Age of AI'),
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=MInZ6B8mKkg',
            'category' => 'Productivity',
            'skill_level' => 'Intermediate',
            'status' => 'active',
            'course_id' => null,
            'section_part_label' => 'Daily Performance Series',
            'sort_order' => 2,
            'description' => 'Part 2: Maintaining focus when AI does the heavy lifting.',
            'tags' => 'deep work, focus, productivity',
        ]);
    }
}
