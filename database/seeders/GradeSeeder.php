<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Grade 7', 'Grade 8', 'Grade 9'] as $name) {
            Grade::query()->firstOrCreate([
                'name' => $name,
            ]);
        }
    }
}
