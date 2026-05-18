<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Order matters: users first, then content, then progress (in UserSeeder)
        $this->call([
            ContentSeeder::class,
            UserSeeder::class,
        ]);
    }
}
