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
        Schema::table('users', function (Blueprint $table) {
            $table->string('account_type')->default('Free Plan')->after('email');
            $table->string('primary_goal')->nullable()->after('account_type');
            $table->string('experience_level')->nullable()->after('primary_goal');
            $table->json('tools')->nullable()->after('experience_level');
            $table->json('interests')->nullable()->after('tools');
            $table->string('role_title')->nullable()->after('interests');
            $table->string('location')->nullable()->after('role_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['account_type', 'primary_goal', 'experience_level', 'tools', 'interests', 'role_title', 'location']);
        });
    }
};
