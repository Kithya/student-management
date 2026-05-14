<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['code' => 'MATH-7', 'name' => 'Mathematics', 'grade' => 'Grade 7', 'teacher' => 'teacher', 'description' => 'Core numeracy, equations, and problem solving.'],
            ['code' => 'SCI-7', 'name' => 'Science', 'grade' => 'Grade 7', 'teacher' => 'ms-sokha', 'description' => 'Introductory earth science and lab habits.'],
            ['code' => 'ENG-8', 'name' => 'English', 'grade' => 'Grade 8', 'teacher' => 'mr-dara', 'description' => 'Reading comprehension, writing, and speaking practice.'],
            ['code' => 'HIS-8', 'name' => 'History', 'grade' => 'Grade 8', 'teacher' => null, 'description' => 'Regional history and timeline projects.'],
            ['code' => 'ICT-9', 'name' => 'Computer Studies', 'grade' => 'Grade 9', 'teacher' => 'teacher', 'description' => 'Digital literacy, spreadsheets, and basic programming ideas.'],
            ['code' => 'BIO-9', 'name' => 'Biology', 'grade' => 'Grade 9', 'teacher' => 'ms-sokha', 'description' => 'Cells, ecosystems, and observation journals.'],
        ];

        foreach ($subjects as $subject) {
            $grade = Grade::query()->where('name', $subject['grade'])->firstOrFail();
            $teacher = $subject['teacher']
                ? User::query()->where('username', $subject['teacher'])->first()
                : null;

            Subject::query()->firstOrCreate([
                'code' => $subject['code'],
            ], [
                'name' => $subject['name'],
                'description' => $subject['description'],
                'grade_id' => $grade->id,
                'teacher_id' => $teacher?->id,
            ]);
        }
    }
}
