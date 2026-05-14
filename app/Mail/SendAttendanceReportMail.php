<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAttendanceReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $period,
        public string $filePath,
    ) {}

    public function build(): static
    {
        return $this->markdown('mail.attendance.reports.attendance-report')
            ->with([
                'period' => $this->period,
                'downloadUrl' => asset('storage/'.$this->filePath),
            ])
            ->attachFromStorageDisk('public', $this->filePath, basename($this->filePath));
    }
}
