<?php

use App\Livewire\Teacher\Attendance\AttendancePage;
use App\Models\Attendance;
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

test('attendance days are only shown after searching with complete filters', function () {
    $grade = Grade::create(['name' => 'Grade 1']);

    Livewire::test(AttendancePage::class)
        ->assertSee('Select a year, month, and grade, then search to load the attendance grid.')
        ->assertDontSee('31')
        ->set('year', 2026)
        ->set('month', 1)
        ->set('grade', $grade->id)
        ->assertDontSee('31')
        ->call('fetchStudents')
        ->assertSee('31')
        ->set('month', 2)
        ->assertDontSee('31')
        ->assertDontSee('28')
        ->call('fetchStudents')
        ->assertSee('28');
});

test('attendance filters stay outside the horizontal table scroll', function () {
    $grade = Grade::create(['name' => 'Grade 1']);

    Livewire::test(AttendancePage::class)
        ->set('year', 2026)
        ->set('month', 2)
        ->set('grade', $grade->id)
        ->call('fetchStudents')
        ->assertSeeHtml('xl:grid-cols-[minmax(14rem,1fr)_auto]')
        ->assertSeeHtml('<div class="overflow-x-auto">');
});

test('attendance does not load students before explicit search', function () {
    $grade = Grade::create(['name' => 'Grade 1']);
    Student::create([
        'first_name' => 'Ada',
        'last_name' => 'Lovelace',
        'age' => 12,
        'grade_id' => $grade->id,
    ]);

    Livewire::test(AttendancePage::class)
        ->set('year', 2026)
        ->set('month', 2)
        ->set('grade', $grade->id)
        ->assertDontSee('Ada Lovelace')
        ->assertSet('hasSearched', false);
});

test('attendance export is disabled until all filters are selected', function () {
    Livewire::test(AttendancePage::class)
        ->assertSeeHtml('wire:click="exportToExcel()"')
        ->assertSeeHtml('disabled');
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
        ->assertSeeHtml("wire:change=\"updateAttendance({$student->id}, 1, \$event.target.value)\"")
        ->assertSeeHtml('aria-label="Attendance for Ada Lovelace on day 1"');
});

test('attendance status can be updated', function () {
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
        ->call('updateAttendance', $student->id, 1, 'absent')
        ->assertSet("attendance.{$student->id}.1", 'absent');

    expect(Attendance::query()
        ->where('student_id', $student->id)
        ->whereDate('date', '2026-02-01')
        ->value('status'))->toBe('absent');
});
