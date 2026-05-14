<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate([
            'username' => 'teacher',
        ], [
            'name' => 'Test User',
            'password' => 'password',
            'role' => 'teacher',
        ]);

        $this->call([
            AdminSeeder::class,
            GradeSeeder::class,
            StudentSeeder::class,
            SubjectSeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}
