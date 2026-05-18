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
        Schema::create('extension_daily_rollups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('extension_device_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date');
            $table->string('timezone')->nullable();
            $table->integer('total_active_ms')->default(0);
            $table->integer('total_idle_ms')->default(0);
            $table->integer('total_open_ms')->default(0);
            $table->integer('sessions_count')->default(0);
            $table->integer('focus_score_avg')->nullable();
            $table->integer('productivity_score_avg')->nullable();
            $table->integer('ai_adoption_score')->nullable();
            $table->json('top_platforms')->nullable();
            $table->json('top_ai_tools')->nullable();
            $table->json('student_learning_needs')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extension_daily_rollups');
    }
};
