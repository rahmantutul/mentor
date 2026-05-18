<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * ConnectedToolsSeeder
 *
 * Maps existing content to real browser domains so the extension can serve
 * contextual recommendations when a user spends 5+ minutes on a site.
 *
 * VISIT MAP (for testing):
 * ─────────────────────────────────────────────────────────
 *  Website you browse 5+ min   → Recommended video category
 * ─────────────────────────────────────────────────────────
 *  chatgpt.com                 → ChatGPT / Prompt Engineering
 *  youtube.com                 → YouTube SEO / Learning
 *  slack.com                   → Slack for Remote Teams
 *  notion.so                   → Notion Productivity
 *  github.com                  → GitHub / CI-CD / DevOps
 *  figma.com                   → Figma UI Design
 *  canva.com                   → Canva Graphic Design
 *  linkedin.com                → LinkedIn Profile / Networking
 *  zoom.us                     → Zoom / Meeting Productivity
 *  mail.google.com             → Gmail / Google Workspace
 *  docs.google.com             → Google Docs / Workspace
 *  sheets.google.com           → Google Sheets / Data Analysis
 *  instagram.com               → Instagram Growth Strategy
 *  facebook.com                → Facebook Ads
 *  google.com / google ads     → Google Ads Tutorial
 */
class ConnectedToolsSeeder extends Seeder
{
    public function run(): void
    {
        // Each entry: [youtube_id_or_title_fragment => [tools_array]]
        // We match by youtube_id (exact) for precision.
        $toolMap = [

            // ── ChatGPT / OpenAI ───────────────────────────────────────
            'T9aRN47eCD0' => ['chatgpt', 'openai'],          // ChatGPT Prompt Engineering for Beginners
            'PaCmpygFfXo' => ['chatgpt', 'openai'],          // How Does ChatGPT Actually Work?
            'pLX6CLLhJBQ' => ['chatgpt', 'openai'],          // ChatGPT for Productivity
            'czvVibB2lRA' => ['chatgpt', 'openai'],          // OpenAI API Python Tutorial
            'kCc8FmEb1nY' => ['chatgpt', 'openai'],          // Build a GPT from Scratch (also general GPT)

            // ── YouTube ────────────────────────────────────────────────
            'wU3BVeTxzBw' => ['youtube'],                    // YouTube SEO – Rank Your Videos
            '2Vv-BfVoq4g' => ['youtube'],                    // Turn YouTube Learning into Action (from ext lib)

            // ── Slack ──────────────────────────────────────────────────
            'YmufQ09c22I' => ['slack'],                      // Slack Basics for Remote Teams

            // ── Notion ────────────────────────────────────────────────
            'oTahLEX3NXo' => ['notion'],                     // Notion for Beginners
            'K0ta8BaFFn8' => ['notion'],                     // Build a Second Brain with Notion

            // ── GitHub ────────────────────────────────────────────────
            'RGOj5yH7evk' => ['github'],                     // Git and GitHub for Beginners
            'R8_veQiYBjI' => ['github'],                     // CI/CD with GitHub Actions

            // ── Figma ─────────────────────────────────────────────────
            'Cx2dkpBxst8' => ['figma'],                      // Figma for Beginners
            'YmdtKC_WKEI' => ['figma'],                      // Figma Advanced Features
            'EK-pHkc5EL4' => ['figma'],                      // Build a Design System in Figma

            // ── Canva ─────────────────────────────────────────────────
            'pjMqUFPBDlY' => ['canva'],                      // Canva Tutorial for Beginners
            'y6120QOlsfU' => ['canva'],                      // Canva AI Content Creation

            // ── LinkedIn ──────────────────────────────────────────────
            'YJF04YFkFkU' => ['linkedin'],                   // LinkedIn Profile Tips
            'tgbNymZ7vqY' => ['linkedin'],                   // AI-Assisted LinkedIn Research

            // ── Zoom ──────────────────────────────────────────────────
            'fJ9rUzIMcZQ' => ['zoom'],                       // Zoom AI Companion Productivity

            // ── Google Workspace (Gmail / Docs / Sheets / Drive) ──────
            '3KTnf89mKCY' => ['gmail', 'google', 'google workspace'], // Google Workspace for Students
            'qNwSHSqCFc'  => ['google sheets', 'sheets', 'google'],   // Google Sheets for Data Analysis

            // ── Google Ads ────────────────────────────────────────────
            'X8oBPDGVDVw' => ['google ads', 'google'],       // Google Ads Tutorial 2024

            // ── Instagram ─────────────────────────────────────────────
            '8uLBe5TZxU8' => ['instagram'],                  // Instagram Growth Strategy

            // ── Facebook / Meta ────────────────────────────────────────
            'Eu5j0QD9e6M' => ['facebook', 'meta'],           // Facebook Ads Full Course

            // ── Microsoft / Teams / Outlook ───────────────────────────
            'AGrl-H87pRU' => ['microsoft', 'power bi'],      // Power BI Full Course

            // ── Zapier / Make / n8n Automation ────────────────────────
            'Vb8kHqzxuKc' => ['zapier', 'automation'],       // Automate Tasks with Zapier
            '4OvpNkOiXOg' => ['make', 'automation'],         // AI Automation with Make.com
            '1MwSoB0gnM4' => ['n8n', 'automation'],          // n8n Automation Tutorial

            // ── Docker / AWS / DevOps ─────────────────────────────────
            '3c-iBn73dDE' => ['docker'],                     // Docker for Web Developers
            'Jnpxou-KOrk' => ['aws'],                        // Deploy to AWS
            'X48VuDVv0do' => ['kubernetes', 'docker'],       // Kubernetes for Beginners

            // ── Grammarly ─────────────────────────────────────────────
            'eIrMbAQSU34' => ['grammarly'],                  // Grammarly AI for Business Writing
        ];

        $updated = 0;

        foreach ($toolMap as $youtubeId => $tools) {
            $rows = DB::table('contents')
                ->where('youtube_id', $youtubeId)
                ->get(['id']);

            foreach ($rows as $row) {
                DB::table('contents')
                    ->where('id', $row->id)
                    ->update(['connected_tools' => json_encode($tools)]);
                $updated++;
            }
        }

        // ── Pattern-based fallback: update by tag/title keywords ──────
        // For any content not in the map above, match by their existing tags
        $patternRules = [
            'chatgpt'        => ['chatgpt', 'openai'],
            'youtube'        => ['youtube'],
            'slack'          => ['slack'],
            'notion'         => ['notion'],
            'github'         => ['github'],
            'figma'          => ['figma'],
            'canva'          => ['canva'],
            'linkedin'       => ['linkedin'],
            'zoom'           => ['zoom'],
            'gmail'          => ['gmail', 'google'],
            'google sheets'  => ['google sheets', 'sheets', 'google'],
            'google ads'     => ['google ads', 'google'],
            'instagram'      => ['instagram'],
            'facebook'       => ['facebook', 'meta'],
            'zapier'         => ['zapier', 'automation'],
            'power bi'       => ['microsoft', 'power bi'],
            'docker'         => ['docker'],
            'kubernetes'     => ['kubernetes', 'docker'],
            'grammarly'      => ['grammarly'],
            'deepseek'       => ['deepseek'],
            'obsidian'       => ['obsidian'],
            'make.com'       => ['make', 'automation'],
            'n8n'            => ['n8n', 'automation'],
        ];

        // Only update rows that still have empty connected_tools
        $emptyRows = DB::table('contents')
            ->whereRaw("JSON_LENGTH(connected_tools) = 0 OR connected_tools IS NULL OR connected_tools = '[]'")
            ->get(['id', 'tags', 'title']);

        foreach ($emptyRows as $row) {
            $haystack = strtolower($row->tags . ' ' . $row->title);
            foreach ($patternRules as $keyword => $tools) {
                if (str_contains($haystack, $keyword)) {
                    DB::table('contents')
                        ->where('id', $row->id)
                        ->update(['connected_tools' => json_encode($tools)]);
                    $updated++;
                    break; // first match wins
                }
            }
        }

        $this->command->info("✅ ConnectedToolsSeeder: updated {$updated} content records.");
    }
}
