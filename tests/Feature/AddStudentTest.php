<?php

use App\Livewire\Teacher\Students\AddStudent;
use App\Models\Grade;
use Livewire\Livewire;

test('grade is required when adding a student', function () {
    Grade::create(['name' => 'Grade 1']);

    Livewire::test(AddStudent::class)
        ->set('first_name', 'Jane')
        ->set('last_name', 'Doe')
        ->set('age', 12)
        ->set('grade', '')
        ->call('save')
        ->assertHasErrors(['grade' => 'required']);
});

test('a student can be added', function () {
    $grade = Grade::create(['name' => 'Grade 1']);

    Livewire::test(AddStudent::class)
        ->set('first_name', 'Jane')
        ->set('last_name', 'Doe')
        ->set('age', 12)
        ->set('grade', $grade->id)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirectToRoute('student.index');

    $this->assertDatabaseHas('students', [
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'age' => 12,
        'grade_id' => $grade->id,
    ]);
});
