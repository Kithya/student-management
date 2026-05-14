<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            'Grade 7' => [
                ['first_name' => 'Lina', 'last_name' => 'Chan', 'age' => 12],
                ['first_name' => 'Vireak', 'last_name' => 'Sok', 'age' => 13],
                ['first_name' => 'Malis', 'last_name' => 'Kim', 'age' => 12],
                ['first_name' => 'Rotha', 'last_name' => 'Phan', 'age' => 13],
            ],
            'Grade 8' => [
                ['first_name' => 'Sophea', 'last_name' => 'Meas', 'age' => 14],
                ['first_name' => 'Dalin', 'last_name' => 'Noun', 'age' => 13],
                ['first_name' => 'Bopha', 'last_name' => 'Keo', 'age' => 14],
                ['first_name' => 'Nara', 'last_name' => 'Long', 'age' => 14],
            ],
            'Grade 9' => [
                ['first_name' => 'Seyha', 'last_name' => 'Lim', 'age' => 15],
                ['first_name' => 'Kanha', 'last_name' => 'Yin', 'age' => 15],
                ['first_name' => 'Pich', 'last_name' => 'Sun', 'age' => 14],
                ['first_name' => 'Sreymom', 'last_name' => 'Hong', 'age' => 15],
            ],
        ];

        foreach ($students as $gradeName => $gradeStudents) {
            $grade = Grade::query()->where('name', $gradeName)->firstOrFail();

            foreach ($gradeStudents as $student) {
                Student::query()->firstOrCreate([
                    'first_name' => $student['first_name'],
                    'last_name' => $student['last_name'],
                ], [
                    'age' => $student['age'],
                    'grade_id' => $grade->id,
                ]);
            }
        }
    }
}
