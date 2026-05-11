<?php

use App\Livewire\Teacher\Attendance\AttendancePage;
use App\Models\Grade;
use App\Models\Student;
use Livewire\Livewire;

test('attendance filters use an accessible search button', function () {
    Livewire::test(AttendancePage::class)
        ->assertSeeHtml('aria-label="Search attendance"')
        ->assertSeeHtml('title="Search attendance"')
        ->assertSeeHtml('wire:click="fetchStudents()"')
        ->assertDontSeeHtml('aria-label="Delete student"');
});

test('attendance days are only shown after selecting a year and month', function () {
    Livewire::test(AttendancePage::class)
        ->assertSee('Select a year and month to show the days.')
        ->assertDontSee('31')
        ->set('year', 2026)
        ->set('month', 1)
        ->assertSee('31')
        ->set('month', 2)
        ->assertDontSee('31')
        ->assertSee('28');
});

test('attendance table shows a status select for each student day', function () {
    $grade = Grade::create(['name' => 'Grade 1']);
    $student = Student::create([
        'first_name' => 'Ada',
        'last_name' => 'Lovelace',
        'age' => 12,
        'grade_id' => $grade->id,
    ]);

    Livewire::test(AttendancePage::class)
        ->set('year', 2026)
        ->set('month', 2)
        ->set('grade', $grade->id)
        ->call('fetchStudents')
        ->assertSee('Ada Lovelace')
        ->assertSet("attendance.{$student->id}.1", 'present')
        ->assertSeeHtml('wire:change="markAll(1, $event.target.value)"')
        ->assertSeeHtml('aria-label="Mark all attendance for day 1"')
        ->assertSeeHtml('wire:model.change="updateAttendace()"')
        ->assertSeeHtml('aria-label="Attendance for Ada Lovelace on day 1"');
});
