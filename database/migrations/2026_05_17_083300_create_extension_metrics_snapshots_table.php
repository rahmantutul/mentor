<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('extension_metrics_snapshots', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('extension_device_id')->constrained('extension_devices')->onDelete('cascade');
            $table->timestamp('captured_at')->nullable();
            $table->integer('window_minutes')->default(60);
            $table->integer('focus_score')->nullable();
            $table->integer('productivity_score')->nullable();
            $table->integer('ai_adoption_score')->nullable();
            $table->integer('workflow_efficiency_score')->nullable();
            $table->bigInteger('active_ms')->default(0);
            $table->bigInteger('idle_ms')->default(0);
            $table->integer('context_switch_count')->default(0);
            $table->integer('tab_switches_per_hour')->default(0);
            $table->json('top_platforms')->nullable();
            $table->json('detected_patterns')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extension_metrics_snapshots');
    }
};
