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
        Schema::create('extension_recommendation_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ext_recommendation_id')->constrained('extension_recommendations')->cascadeOnDelete();
            $table->string('event_type');
            $table->timestamp('occurred_at')->nullable();
            $table->json('context')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extension_recommendation_events');
    }
};
