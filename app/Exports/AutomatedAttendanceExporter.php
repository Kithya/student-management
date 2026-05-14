<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AutomatedAttendanceExporter implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;

    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return Attendance::whereBetween('date', [$this->startDate, $this->endDate])->get();
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
