<div>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-stats-card title="Total Students" tooltip="Showing number of all active students" :value="$totalStudents" />

        @if ($showAdminStats)
            <x-stats-card title="Total Users" tooltip="Showing number of all active users" :value="$totalUsers" />
            <x-stats-card title="Total Teachers" tooltip="Showing number of all active teachers" :value="$totalTeachers" />
        @endif

        <x-stats-card title="Attendance Today" :value="$attendanceToday" />
        <x-stats-card title="Present Today" :value="$presentToday" />
        <x-stats-card title="Absent Today" :value="$absentToday" />
        <x-stats-card title="Weekly Attendance Rate" :value="$weeklyAttendanceRate . '%'" :percentage="$weeklyAttendanceRate" />
    </div>

    @php
        $maxTrend = max(collect($monthlyTrends)->max('count') ?? 0, 1);
    @endphp

    <div class="mt-6 rounded-lg border border-layer-line bg-layer p-6 shadow-2xs">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-foreground">Monthly Attendance Trends</h3>
            <p class="text-sm text-muted-foreground-2">Present attendance count by day.</p>
        </div>

        <div class="flex h-64 items-end gap-1 overflow-x-auto border-b border-layer-line pb-3">
            @foreach ($monthlyTrends as $trend)
                <div class="flex min-w-7 flex-1 flex-col items-center gap-2">
                    <div class="flex h-52 w-full items-end">
                        <div class="w-full rounded-t bg-primary"
                            style="height: {{ max(6, ($trend['count'] / $maxTrend) * 100) }}%"
                            title="Day {{ $trend['day'] }}: {{ $trend['count'] }}"></div>
                    </div>
                    <span class="text-[11px] text-muted-foreground-2">{{ $trend['day'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
