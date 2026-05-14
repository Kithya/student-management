<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $year;

    protected $month;

    protected $grade;

    public function __construct($year, $month, $grade)
    {
        $this->year = $year;
        $this->month = $month;
        $this->grade = $grade;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return Attendance::whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->whereHas('student', function ($query) {
                $query->where('grade_id', $this->grade);
            })
            ->get();
    }

    public function map($row): array
    {
        return [
            $row->student->first_name.' '.$row->student->last_name,
            $row->date,
            ucfirst($row->status),
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
