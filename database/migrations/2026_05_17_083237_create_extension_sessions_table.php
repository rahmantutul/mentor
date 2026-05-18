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
        Schema::create('extension_sessions', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('extension_device_id')->constrained('extension_devices')->onDelete('cascade');
            $table->string('session_id_from_ext')->index();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->string('platform_type')->nullable();
            $table->string('platform_domain')->nullable();
            $table->string('platform_category')->nullable();
            $table->boolean('is_ai_tool')->default(false);
            $table->bigInteger('active_ms')->default(0);
            $table->bigInteger('idle_ms')->default(0);
            $table->bigInteger('open_ms')->default(0);
            $table->integer('click_count')->default(0);
            $table->integer('interaction_count')->default(0);
            $table->integer('page_count')->default(0);
            $table->integer('tab_switch_count')->default(0);
            $table->json('pages')->nullable();
            $table->json('local_signals')->nullable();
            $table->json('recommended_content_tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extension_sessions');
    }
};
