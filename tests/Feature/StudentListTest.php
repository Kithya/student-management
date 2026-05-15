<?php

use App\Livewire\Teacher\Students\StudentList;
use App\Models\Grade;
use App\Models\Student;
use Livewire\Livewire;

test('students are listed by ascending id', function () {
    $grade = Grade::create(['name' => 'Grade 1']);

    $firstStudent = Student::create([
        'first_name' => 'Charlie',
        'last_name' => 'Young',
        'age' => 12,
        'grade_id' => $grade->id,
    ]);

    $secondStudent = Student::create([
        'first_name' => 'Alice',
        'last_name' => 'Adams',
        'age' => 13,
        'grade_id' => $grade->id,
    ]);

    $thirdStudent = Student::create([
        'first_name' => 'Bob',
        'last_name' => 'Baker',
        'age' => 14,
        'grade_id' => $grade->id,
    ]);

    Livewire::test(StudentList::class)
        ->assertViewHas('students', function ($students) use ($firstStudent, $secondStudent, $thirdStudent): bool {
            return $students->pluck('id')->all() === [
                $firstStudent->id,
                $secondStudent->id,
                $thirdStudent->id,
            ];
        })
        ->assertSeeInOrder([
            'Charlie',
            'Alice',
            'Bob',
        ]);
});
