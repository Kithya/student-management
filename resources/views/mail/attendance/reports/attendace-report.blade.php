<x-mail::message>
    # Attendance Report

    Hello,

    Your attendance report for **{{ $period ?? 'the selected period' }}** is ready.

    The report has been attached to this email. You can also download a copy using the button below.

    @isset($downloadUrl)
        <x-mail::button :url="$downloadUrl">
            Download Report
        </x-mail::button>
    @endisset

    <x-mail::panel>
        Please review the attached spreadsheet for student attendance records, including the attendance date and status.
    </x-mail::panel>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
