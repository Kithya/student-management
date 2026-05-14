<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected int|string $year,
        protected int|string $month,
        protected int|string $grade,
    ) {}

    /**
     * @return Collection
     */
    public function collection()
    {
        return Attendance::query()
            ->with('student')
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->where('grade_id', $this->grade)
            ->get();
    }

    public function map($row): array
    {
        return [
            $row->student->first_name.' '.$row->student->last_name,
            $row->date,
            ucfirst($row->status),
            $row->reason,
        ];
    }

    public function headings(): array
    {
        return [
            'Student Name',
            'Date',
            'Status',
            'Reason',
        ];
    }
}
