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
        Schema::table('browsing_histories', function (Blueprint $table) {
            // Ensure URL length is compatible with index
            $table->string('url', 255)->change();
            
            // Add unique constraint for efficient upserts
            $table->unique(['user_id', 'url', 'timestamp'], 'uid_url_ts_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('browsing_histories', function (Blueprint $table) {
            $table->dropUnique('uid_url_ts_unique');
        });
    }
};
