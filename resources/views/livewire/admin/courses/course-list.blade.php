<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="bg-layer border border-layer-line rounded-lg shadow-2xs overflow-hidden">
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-table-line">
            <div>
                <h2 class="text-xl font-semibold text-foreground">Courses</h2>
                <p class="text-sm text-muted-foreground-2">Manage course subjects, grades, and teacher assignments.</p>
            </div>

            <a class="py-2 px-3 inline-flex items-center justify-center gap-x-2 text-sm font-medium rounded-lg bg-primary border border-primary-line text-primary-foreground hover:bg-primary-hover focus:outline-hidden focus:bg-primary-focus"
                href="{{ route('course.create') }}" wire:navigate>
                Create
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-table-line">
                <thead class="bg-muted">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold uppercase text-foreground">Code</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold uppercase text-foreground">Subject</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold uppercase text-foreground">Grade</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold uppercase text-foreground">Teacher</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold uppercase text-foreground">Description</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold uppercase text-foreground">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-table-line">
                    @forelse ($courses as $course)
                        <tr wire:key="course-{{ $course->id }}" class="hover:bg-muted/40">
                            <td class="px-6 py-3 text-sm font-semibold text-foreground whitespace-nowrap">{{ $course->code }}</td>
                            <td class="px-6 py-3 text-sm text-foreground whitespace-nowrap">{{ $course->name }}</td>
                            <td class="px-6 py-3 text-sm text-muted-foreground-2 whitespace-nowrap">{{ $course->grade?->name }}</td>
                            <td class="px-6 py-3 text-sm text-muted-foreground-2 whitespace-nowrap">{{ $course->teacher?->name ?? 'Unassigned' }}</td>
                            <td class="px-6 py-3 text-sm text-muted-foreground-2 min-w-72">
                                {{ $course->description ? Illuminate\Support\Str::limit($course->description, 80) : 'No description' }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('course.edit', $course->id) }}" wire:navigate
                                        class="inline-flex h-9 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 px-3 text-sm font-medium text-blue-700 hover:bg-blue-100 dark:border-blue-400/30 dark:bg-blue-400/10 dark:text-blue-300">
                                        Edit
                                    </a>
                                    <button type="button" wire:click="delete({{ $course->id }})"
                                        wire:confirm="Delete this course?"
                                        class="inline-flex h-9 items-center justify-center rounded-lg border border-red-200 bg-red-50 px-3 text-sm font-medium text-red-700 hover:bg-red-100 dark:border-red-400/30 dark:bg-red-400/10 dark:text-red-300">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-muted-foreground-2">
                                No courses have been created.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-table-line">
            <p class="text-sm text-muted-foreground-2"><span class="font-semibold text-foreground">{{ $courses->count() }}</span> results</p>
        </div>
    </div>
</div>
