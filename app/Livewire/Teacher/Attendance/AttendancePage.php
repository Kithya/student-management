<?php

namespace App\Livewire\Teacher\Attendance;

use App\Exports\AttendanceExport;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Masmerise\Toaster\Toaster;

#[Layout('components.layouts.app')]
class AttendancePage extends Component
{
    public $year;

    public $month;

    public $grade;

    public $students = [];

    public $attendance = [];

    public $grades = [];

    public bool $hasSearched = false;

    public function mount(): void
    {
        $this->grades = Grade::query()
            ->orderBy('name')
            ->get();
    }

    public function fetchStudents(): void
    {
        $this->validate([
            'year' => ['required', 'integer'],
            'month' => ['required', 'integer', 'between:1,12'],
            'grade' => ['required', 'exists:grades,id'],
        ]);

        $this->hasSearched = true;
        $this->attendance = [];

        $this->students = Student::query()
            ->where('grade_id', $this->grade)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        if ($this->students->isEmpty()) {
            return;
        }

        $startDate = Carbon::create((int) $this->year, (int) $this->month, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth();
        $daysInMonth = $startDate->daysInMonth;

        $attendanceRecords = Attendance::query()
            ->whereIn('student_id', $this->students->pluck('id'))
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->get()
            ->keyBy(fn (Attendance $attendance): string => $attendance->student_id.'-'.Carbon::parse($attendance->date)->day);

        foreach ($this->students as $student) {
            foreach (range(1, $daysInMonth) as $day) {
                $this->attendance[$student->id][$day] = $attendanceRecords->get($student->id.'-'.$day)?->status ?? 'present';
            }
        }
    }

    public function updateAttendance(int $studentId, int $day, string $status): void
    {
        if (! $this->isReady() || ! $this->isValidStatus($status)) {
            return;
        }

        $this->persistAttendance($studentId, $day, $status);
        $this->attendance[$studentId][$day] = $status;

        Toaster::success('Attendance updated successfully.');
    }

    public function markAll(int $day, string $status): void
    {
        if (! $this->isReady() || ! $this->isValidStatus($status)) {
            return;
        }

        foreach ($this->students as $student) {
            $this->persistAttendance($student->id, $day, $status);
            $this->attendance[$student->id][$day] = $status;
        }

        Toaster::success('Attendance updated successfully.');
    }

    public function exportToExcel()
    {
        if (! $this->isReady()) {
            $this->addError('filters', 'Select a year, month, and grade before exporting.');
            Toaster::error('Select a year, month, and grade before exporting.');

            return null;
        }

        return Excel::download(new AttendanceExport($this->year, $this->month, $this->grade), 'attendance.xlsx');
    }

    public function updated(string $property): void
    {
        if (in_array($property, ['year', 'month', 'grade'], true)) {
            $this->students = [];
            $this->attendance = [];
            $this->hasSearched = false;
        }
    }

    public function render(): View
    {
        return view('livewire.teacher.attendance.attendance-page', [
            'daysInMonth' => $this->hasSearched && $this->year && $this->month
                ? Carbon::create((int) $this->year, (int) $this->month)->daysInMonth
                : null,
            'canExport' => $this->isReady(),
        ]);
    }

    private function persistAttendance(int $studentId, int $day, string $status): void
    {
        $date = Carbon::create((int) $this->year, (int) $this->month, $day)->format('Y-m-d');

        Attendance::updateOrCreate([
            'student_id' => $studentId,
            'date' => $date,
        ], [
            'status' => $status,
            'grade_id' => $this->grade,
        ]);
    }

    private function isReady(): bool
    {
        return filled($this->year) && filled($this->month) && filled($this->grade);
    }

    private function isValidStatus(string $status): bool
    {
        return in_array($status, ['present', 'absent', 'sick', 'other'], true);
    }
}
