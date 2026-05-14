<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-foreground sm:text-3xl">Edit course</h1>
            <p class="mt-2 text-sm text-muted-foreground-2">Update course details and teacher assignment.</p>
        </div>

        <a href="{{ route('course.index') }}" wire:navigate
            class="inline-flex items-center justify-center rounded-lg border border-layer-line bg-layer px-3 py-2 text-sm font-medium text-layer-foreground shadow-2xs hover:bg-layer-hover">
            Back
        </a>
    </div>

    <form wire:submit="update" class="bg-layer border border-layer-line rounded-lg p-6 shadow-2xs space-y-6">
        <div class="grid gap-5 sm:grid-cols-2">
            <flux:input wire:model="code" label="Code" type="text" required />
            <flux:input wire:model="name" label="Subject name" type="text" required />
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="grade_id" class="block text-sm font-medium text-foreground">Grade</label>
                <select id="grade_id" wire:model="grade_id"
                    class="mt-2 block h-10 w-full rounded-lg border border-layer-line bg-layer px-3 text-sm text-foreground shadow-2xs focus:border-primary-focus focus:outline-hidden focus:ring-2 focus:ring-primary-focus/20">
                    <option value="">Select grade</option>
                    @foreach ($grades as $grade)
                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                    @endforeach
                </select>
                @error('grade_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="teacher_id" class="block text-sm font-medium text-foreground">Teacher</label>
                <select id="teacher_id" wire:model="teacher_id"
                    class="mt-2 block h-10 w-full rounded-lg border border-layer-line bg-layer px-3 text-sm text-foreground shadow-2xs focus:border-primary-focus focus:outline-hidden focus:ring-2 focus:ring-primary-focus/20">
                    <option value="">Unassigned</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
                @error('teacher_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <flux:textarea wire:model="description" label="Description" rows="4" />

        <div class="flex justify-end gap-3">
            <a href="{{ route('course.index') }}" wire:navigate
                class="inline-flex items-center justify-center rounded-lg border border-layer-line bg-layer px-4 py-2.5 text-sm font-medium text-layer-foreground shadow-2xs hover:bg-layer-hover">
                Cancel
            </a>
            <flux:button variant="primary" type="submit">Update course</flux:button>
        </div>
    </form>
</div>
