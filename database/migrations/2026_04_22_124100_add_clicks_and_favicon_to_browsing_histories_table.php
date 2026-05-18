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
            $table->json('clicks')->nullable()->after('search_query');
            $table->text('favicon')->nullable()->after('clicks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('browsing_histories', function (Blueprint $table) {
            $table->dropColumn(['clicks', 'favicon']);
        });
    }
};
