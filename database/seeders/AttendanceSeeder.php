<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::now()->startOfMonth();
        $today = Carbon::today();

        Student::query()
            ->orderBy('id')
            ->get()
            ->each(function (Student $student) use ($startDate, $today): void {
                foreach ($startDate->copy()->daysUntil($today) as $date) {
                    if ($date->isWeekend()) {
                        continue;
                    }

                    $dayOffset = $date->day + $student->id;
                    $status = match (true) {
                        $dayOffset % 17 === 0 => 'sick',
                        $dayOffset % 11 === 0 => 'absent',
                        $dayOffset % 13 === 0 => 'other',
                        default => 'present',
                    };

                    Attendance::query()->updateOrCreate([
                        'student_id' => $student->id,
                        'date' => $date->toDateString(),
                    ], [
                        'grade_id' => $student->grade_id,
                        'status' => $status,
                        'reason' => $status === 'present' ? null : ucfirst($status).' note',
                    ]);
                }
            });
    }
}
