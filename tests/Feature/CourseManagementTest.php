<?php

use App\Livewire\Admin\Courses\AddCourse;
use App\Livewire\Admin\Courses\CourseList;
use App\Livewire\Admin\Courses\EditCourse;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use Livewire\Livewire;

test('admin can create a course', function () {
    $admin = User::factory()->admin()->create();
    $grade = Grade::create(['name' => 'Grade 1']);
    $teacher = User::factory()->teacher()->create(['name' => 'Ada Teacher']);

    Livewire::actingAs($admin)
        ->test(AddCourse::class)
        ->set('code', 'MATH-101')
        ->set('name', 'Mathematics')
        ->set('description', 'Numbers and problem solving')
        ->set('grade_id', (string) $grade->id)
        ->set('teacher_id', (string) $teacher->id)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirectToRoute('course.index');

    $this->assertDatabaseHas('subjects', [
        'code' => 'MATH-101',
        'name' => 'Mathematics',
        'grade_id' => $grade->id,
        'teacher_id' => $teacher->id,
    ]);
});

test('course requires code name and grade', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(AddCourse::class)
        ->call('save')
        ->assertHasErrors([
            'code' => 'required',
            'name' => 'required',
            'grade_id' => 'required',
        ]);
});

test('course teacher assignment must reference a teacher user', function () {
    $admin = User::factory()->admin()->create();
    $grade = Grade::create(['name' => 'Grade 1']);
    $notTeacher = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(AddCourse::class)
        ->set('code', 'SCI-101')
        ->set('name', 'Science')
        ->set('grade_id', (string) $grade->id)
        ->set('teacher_id', (string) $notTeacher->id)
        ->call('save')
        ->assertHasErrors(['teacher_id']);
});

test('admin can edit and delete a course', function () {
    $admin = User::factory()->admin()->create();
    $grade = Grade::create(['name' => 'Grade 1']);
    $newGrade = Grade::create(['name' => 'Grade 2']);
    $course = Subject::factory()->create([
        'code' => 'ENG-101',
        'name' => 'English',
        'grade_id' => $grade->id,
        'teacher_id' => null,
    ]);

    Livewire::actingAs($admin)
        ->test(EditCourse::class, ['id' => $course->id])
        ->set('code', 'ENG-201')
        ->set('name', 'Advanced English')
        ->set('grade_id', (string) $newGrade->id)
        ->call('update')
        ->assertHasNoErrors()
        ->assertRedirectToRoute('course.index');

    $this->assertDatabaseHas('subjects', [
        'id' => $course->id,
        'code' => 'ENG-201',
        'name' => 'Advanced English',
        'grade_id' => $newGrade->id,
    ]);

    Livewire::actingAs($admin)
        ->test(CourseList::class)
        ->call('delete', $course->id);

    $this->assertDatabaseMissing('subjects', ['id' => $course->id]);
});

test('course list shows grade and assigned teacher', function () {
    $admin = User::factory()->admin()->create();
    $grade = Grade::create(['name' => 'Grade 1']);
    $teacher = User::factory()->teacher()->create(['name' => 'Grace Hopper']);

    Subject::factory()->create([
        'code' => 'CS-101',
        'name' => 'Computer Science',
        'grade_id' => $grade->id,
        'teacher_id' => $teacher->id,
    ]);

    Livewire::actingAs($admin)
        ->test(CourseList::class)
        ->assertSee('CS-101')
        ->assertSee('Computer Science')
        ->assertSee('Grade 1')
        ->assertSee('Grace Hopper');
});
