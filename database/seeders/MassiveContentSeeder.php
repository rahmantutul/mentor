<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Content;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class MassiveContentSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Content::truncate();
        Course::truncate();
        Schema::enableForeignKeyConstraints();

        $categories = [
            'AI Automation',
            'Digital Marketing',
            'Data Science',
            'UI/UX Design',
            'Cloud Computing',
            'Web Development',
            'Business Strategy'
        ];

        $levels = ['Beginner', 'Intermediate', 'Advanced'];

        // Real working YouTube videos
        $ytVideos = [
            'rfscVS0vtbw',
            'ua-CiDNNj30',
            'Ke90Tje7VS0',
            '3JluqTojuME',
            'PkZNo7MFNFg',
            'UB1O30fR-EE',
            'yfoY53QXEnI',
            'RGOj5yH7evk',
            '8hly31xKli0',
            '7eh4d6sabA0',
            'Z1RJmh_OqeA',
            'TlB_eWDSMt4',
            'Q33KBiDriJY',
            'Oe421EPjeBE'
        ];

        $courseData = [
            ['title' => 'Python for AI Engineers', 'img' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=800&q=80'],
            ['title' => 'Full-Stack AI Development 2026', 'img' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&q=80'],
            ['title' => 'Growth Hacking with LLMs', 'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80'],
            ['title' => 'Modern UX Architecture', 'img' => 'https://images.unsplash.com/photo-1586717791821-3f44a563eb4c?w=800&q=80'],
            ['title' => 'AWS Cloud Practitioner Masterclass', 'img' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&q=80'],
            ['title' => 'Data Visualization with Tableau', 'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80'],
            ['title' => 'Cybersecurity Fundamentals', 'img' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800&q=80'],
            ['title' => 'Prompt Engineering Professional', 'img' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&q=80']
        ];

        $courses = [];

        // Create courses
        foreach ($courseData as $index => $data) {
            $courses[] = Course::create([
                'title' => $data['title'],
                'description' => "Complete professional guide to {$data['title']}.",
                'category' => $categories[$index % count($categories)],
                'status' => 'active',
                'thumbnail' => $data['img'],
            ]);
        }

        // Create course contents
        foreach ($courses as $course) {
            for ($i = 1; $i <= 20; $i++) {

                $videoId = $ytVideos[array_rand($ytVideos)];

                $title = $course->title . " - Lesson {$i}: " . $this->getRandomTopic($course->category);

                Content::create([
                    'title' => $title,
                    'slug' => Str::slug($title . '-' . uniqid()),
                    'type' => 'video',
                    'video_url' => "https://www.youtube.com/watch?v={$videoId}",
                    'thumbnail' => "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg",
                    'category' => $course->category,
                    'skill_level' => $levels[array_rand($levels)],
                    'status' => 'active',
                    'course_id' => $course->id,
                    'section_part_label' => "Module " . ceil($i / 5),
                    'sort_order' => $i,
                    'description' => "Deep dive into lesson {$i} of {$course->title}.",
                    'tags' => strtolower($course->category) . ", tutorial",
                    'tools' => 'VS Code, AI Tools',
                    'is_featured' => $i === 1,
                ]);
            }
        }

        // Standalone videos
        for ($i = 1; $i <= 100; $i++) {
            $cat = $categories[array_rand($categories)];
            $videoId = $ytVideos[array_rand($ytVideos)];

            $title = "Standalone Guide: " . $this->getRandomTopic($cat) . " #{$i}";

            Content::create([
                'title' => $title,
                'slug' => Str::slug($title . '-' . uniqid()),
                'type' => 'video',
                'video_url' => "https://www.youtube.com/watch?v={$videoId}",
                'thumbnail' => "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg",
                'category' => $cat,
                'skill_level' => $levels[array_rand($levels)],
                'status' => 'active',
                'course_id' => null,
                'section_part_label' => rand(0, 1) ? 'Quick Tips' : null,
                'sort_order' => 0,
                'description' => "Quick standalone lesson on {$title}.",
                'tags' => strtolower($cat) . ", quick-guide",
                'tools' => 'AI, Figma, Cloud',
            ]);
        }
    }

    private function getRandomTopic($category)
    {
        $topics = [
            'AI Automation' => ['Zapier Workflows', 'Custom GPTs', 'API Integration', 'Automation Pipelines'],
            'Digital Marketing' => ['SEO Strategy', 'Facebook Ads', 'Email Funnels', 'Conversion Optimization'],
            'Data Science' => ['Pandas Cleaning', 'Neural Networks', 'Regression Models'],
            'UI/UX Design' => ['Design Systems', 'Micro-interactions', 'Accessibility'],
            'Cloud Computing' => ['AWS Lambda', 'S3 Buckets', 'Cloud Security'],
            'Web Development' => ['Laravel APIs', 'React Components', 'Performance Optimization'],
            'Business Strategy' => ['Market Analysis', 'Scaling Strategies', 'Leadership']
        ];

        return $topics[$category][array_rand($topics[$category])];
    }
}