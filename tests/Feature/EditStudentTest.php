<?php

use App\Livewire\Teacher\Students\EditStudent;
use App\Models\Grade;
use App\Models\Student;
use Livewire\Livewire;

test('a student can be updated', function () {
    $originalGrade = Grade::create(['name' => 'Grade 1']);
    $newGrade = Grade::create(['name' => 'Grade 2']);
    $student = Student::create([
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'age' => 12,
        'grade_id' => $originalGrade->id,
    ]);

    Livewire::test(EditStudent::class, ['id' => $student->id])
        ->set('first_name', 'Janet')
        ->set('last_name', 'Rivera')
        ->set('age', 13)
        ->set('grade', $newGrade->id)
        ->call('update')
        ->assertHasNoErrors()
        ->assertRedirectToRoute('student.index');

    $this->assertDatabaseHas('students', [
        'id' => $student->id,
        'first_name' => 'Janet',
        'last_name' => 'Rivera',
        'age' => 13,
        'grade_id' => $newGrade->id,
    ]);
});

test('grade is required when updating a student', function () {
    $grade = Grade::create(['name' => 'Grade 1']);
    $student = Student::create([
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'age' => 12,
        'grade_id' => $grade->id,
    ]);

    Livewire::test(EditStudent::class, ['id' => $student->id])
        ->set('grade', '')
        ->call('update')
        ->assertHasErrors(['grade' => 'required']);
});
