<?php

namespace App\Livewire\Teacher\Attendance;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class AttendancePage extends Component
{
    public $year;

    public $month;

    public $grade;

    public $students = [];

    public $attendance = [];

    public $grades = [];

    public function mount(): void
    {
        $this->grades = Grade::all();
    }

    public function fetchStudents(): void
    {
        if ($this->year && $this->month && $this->grade) {
            $this->students = Student::where('grade_id', $this->grade)->get();

            foreach ($this->students as $student) {
                foreach (range(1, Carbon::create($this->year, $this->month)->daysInMonth) as $day) {
                    $date = Carbon::create($this->year, $this->month, $day)->format('Y-m-d');
                    $this->attendance[$student->id][$day] = Attendance::where('student_id', $student->id)
                        ->whereDate('date', $date)
                        ->value('status') ?? 'present';
                }
            }
        }
    }

    public function render(): View
    {
        return view('livewire.teacher.attendance.attendance-page', [
            'daysInMonth' => $this->year && $this->month
                ? Carbon::create((int) $this->year, (int) $this->month)->daysInMonth
                : null,
        ]);
    }
}
