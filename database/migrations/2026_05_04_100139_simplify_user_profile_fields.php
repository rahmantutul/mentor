<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new clean fields
            if (!Schema::hasColumn('users', 'learning_goal')) {
                $table->string('learning_goal')->nullable()->after('email');
            }

            // Keep interests (already exists as JSON from previous migration)
            // Drop old unused fields safely
            $oldFields = ['account_type', 'primary_goal', 'tools', 'role_title', 'location'];
            foreach ($oldFields as $field) {
                if (Schema::hasColumn('users', $field)) {
                    $table->dropColumn($field);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('learning_goal');
            $table->string('account_type')->default('Free Plan');
            $table->string('primary_goal')->nullable();
            $table->json('tools')->nullable();
            $table->string('role_title')->nullable();
            $table->string('location')->nullable();
        });
    }
};
