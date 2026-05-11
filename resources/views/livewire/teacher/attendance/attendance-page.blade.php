<div>
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="bg-layer border border-layer-line rounded-xl shadow-2xs overflow-hidden">
                        <div
                            class="grid gap-4 border-b border-table-line px-4 py-4 sm:px-6 lg:flex lg:items-center lg:justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-foreground">
                                    Attendance
                                </h2>
                                <p class="text-sm text-muted-foreground-2">
                                    Attendance overview.
                                </p>
                            </div>

                            <div
                                class="grid w-full grid-cols-1 gap-2 sm:grid-cols-[minmax(8rem,1fr)_minmax(10rem,1fr)_minmax(10rem,1fr)_auto] lg:w-auto">
                                <select wire:model.live="year"
                                    class="block h-10 w-full rounded-lg border border-layer-line bg-layer px-3 pe-9 text-sm text-foreground shadow-2xs transition focus:border-primary-focus focus:outline-hidden focus:ring-2 focus:ring-primary-focus/25 disabled:pointer-events-none disabled:opacity-50">
                                    <option value="">Select Year</option>
                                    @foreach (range(now()->year - 5, now()->year) as $yearOption)
                                        <option value="{{ $yearOption }}">{{ $yearOption }}</option>
                                    @endforeach
                                </select>

                                <select wire:model.live="month"
                                    class="block h-10 w-full rounded-lg border border-layer-line bg-layer px-3 pe-9 text-sm text-foreground shadow-2xs transition focus:border-primary-focus focus:outline-hidden focus:ring-2 focus:ring-primary-focus/25 disabled:pointer-events-none disabled:opacity-50">
                                    <option value="">Select Month</option>
                                    @foreach (range(1, 12) as $monthOption)
                                        <option value="{{ $monthOption }}">
                                            {{ Carbon\Carbon::create()->month($monthOption)->format('F') }}</option>
                                    @endforeach
                                </select>

                                <select wire:model.live="grade"
                                    class="block h-10 w-full rounded-lg border border-layer-line bg-layer px-3 pe-9 text-sm text-foreground shadow-2xs transition focus:border-primary-focus focus:outline-hidden focus:ring-2 focus:ring-primary-focus/25 disabled:pointer-events-none disabled:opacity-50">
                                    <option value="">Select Grade</option>
                                    @foreach ($grades as $gradeOption)
                                        <option value="{{ $gradeOption->id }}">{{ $gradeOption->name }}</option>
                                    @endforeach
                                </select>

                                <button type="button" wire:click="fetchStudents()" aria-label="Search attendance"
                                    title="Search attendance"
                                    class="group inline-flex h-10 w-full items-center justify-center rounded-lg border border-blue-200 bg-blue-50 text-blue-700 shadow-2xs transition hover:-translate-y-0.5 hover:border-blue-300 hover:bg-blue-100 hover:text-blue-800 hover:shadow-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500/30 disabled:pointer-events-none disabled:opacity-50 sm:w-10 dark:border-blue-400/30 dark:bg-blue-400/10 dark:text-blue-300 dark:hover:bg-blue-400/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="size-4.5 transition group-hover:scale-110">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @if ($daysInMonth)
                            <table class="min-w-full divide-y divide-table-line">
                                <thead class="divide-y divide-table-line bg-muted">
                                    <tr>
                                        <th scope="col"
                                            class="sticky left-0 z-20 min-w-60 bg-muted px-6 py-3 text-start border-s border-table-line shadow-[1px_0_0_var(--color-table-line)]">
                                            <span class="text-xs font-semibold uppercase text-foreground">
                                                Student Name
                                            </span>
                                        </th>

                                        @foreach (range(1, $daysInMonth) as $day)
                                            <th scope="col"
                                                class="min-w-32 border-s border-table-line px-2 py-3 text-center">
                                                <div class="flex flex-col items-center gap-2">
                                                    <span
                                                        class="inline-flex size-7 items-center justify-center rounded-md bg-layer text-xs font-semibold text-foreground shadow-2xs">
                                                        {{ $day }}
                                                    </span>

                                                    <select wire:change="markAll()"
                                                        aria-label="Mark all attendance for day {{ $day }}"
                                                        class="block h-8 w-full min-w-28 rounded-lg border border-layer-line bg-layer px-2 pe-7 text-xs font-medium text-muted-foreground-2 shadow-2xs transition hover:border-primary-focus/60 focus:border-primary-focus focus:outline-hidden focus:ring-2 focus:ring-primary-focus/25 disabled:pointer-events-none disabled:opacity-50">
                                                        <option value="">All</option>
                                                        <option value="present">Present</option>
                                                        <option value="absent">Absent</option>
                                                        <option value="sick">Sick</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-table-line">
                                    @forelse ($students as $student)
                                        <tr wire:key="attendance-student-{{ $student->id }}"
                                            class="group hover:bg-muted/40">
                                            <td
                                                class="sticky left-0 z-10 h-px min-w-60 whitespace-nowrap border-s border-table-line bg-layer shadow-[1px_0_0_var(--color-table-line)] group-hover:bg-muted">
                                                <div class="px-6 py-3.5">
                                                    <span class="block text-sm font-medium text-foreground">
                                                        {{ $student->first_name }} {{ $student->last_name }}
                                                    </span>
                                                </div>
                                            </td>

                                            @foreach (range(1, $daysInMonth) as $day)
                                                <td
                                                    class="h-px min-w-32 border-s border-table-line bg-layer px-2 py-2 group-hover:bg-muted/40">
                                                    <select wire:model.change="updateAttendace()"
                                                        aria-label="Attendance for {{ $student->first_name }} {{ $student->last_name }} on day {{ $day }}"
                                                        class="block h-9 w-full min-w-28 rounded-lg border border-layer-line bg-layer px-2.5 pe-8 text-xs font-medium text-foreground shadow-2xs transition hover:border-primary-focus/60 focus:border-primary-focus focus:outline-hidden focus:ring-2 focus:ring-primary-focus/25 disabled:pointer-events-none disabled:opacity-50">
                                                        <option value="present">Present</option>
                                                        <option value="absent">Absent</option>
                                                        <option value="sick">Sick</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ $daysInMonth + 1 }}" class="px-6 py-8 text-center">
                                                <p class="text-sm text-muted-foreground-2">
                                                    Select a grade and search to load students.
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @else
                            <div class="px-6 py-12 text-center">
                                <p class="text-sm text-muted-foreground-2">
                                    Select a year and month to show the days.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
