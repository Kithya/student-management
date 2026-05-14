<?php

namespace App\Console\Commands;

use App\Exports\AutomatedAttendanceExporter;
use App\Mail\SendAttendanceReportMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class SendAttendaceReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:send-report {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Attendance Report';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        if ($type == 'daily') {
            $startDate = $yesterday;
            $endDate = $today;
        } elseif ($type == 'weekly') {
            $startDate = $today->copy()->startOfWeek();
            $endDate = $today->copy()->endOfWeek();
        } else {
            $this->error('Invalid type of report');

            return;
        }

        $fileName = 'attendance_report_{$type}.xlsx';

        $filePath = 'attendace_reports/{$fileName}';

        Excel::store(new AutomatedAttendanceExporter($startDate, $endDate), $filePath, 'public');
        Mail::to('narakithya@gmail.com')->send(new SendAttendanceReportMail($type, $filePath));

        $this->info('{$type} attendance report sent successfully');
    }
}
