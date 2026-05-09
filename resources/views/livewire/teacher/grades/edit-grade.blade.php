<div class="px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto flex max-w-4xl flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-primary">Student Management</p>
                <h1 class="mt-1 text-2xl font-semibold text-foreground sm:text-3xl">Edit student grade</h1>
                <p class="mt-2 max-w-2xl text-sm text-muted-foreground-2">
                    Update the student record to keep it accurate and easy to scan.
                </p>
            </div>

            <a href="{{ route('grade.index') }}" wire:navigate
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-layer-line bg-layer px-3 py-2 text-sm font-medium text-layer-foreground shadow-2xs transition hover:bg-layer-hover focus:outline-hidden focus:ring-2 focus:ring-primary-focus/30">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Back to grades
            </a>
        </div>

        <form wire:submit="update" class="overflow-hidden rounded-xl border border-card-line bg-card shadow-2xs">
            <div class="border-b border-card-line bg-muted/50 px-5 py-4 sm:px-6">
                <h2 class="text-base font-semibold text-foreground">Edit Grade</h2>
                <p class="mt-1 text-sm text-muted-foreground-2">Keep the student record accurate and easy to scan.</p>
            </div>

            <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-foreground">Grade Name</label>
                    <input id="name" type="text" wire:model="name" autocomplete="given-name"
                        class="mt-2 block w-full rounded-lg border border-layer-line bg-layer px-3 py-2.5 text-sm text-foreground placeholder:text-muted-foreground-1 shadow-2xs transition focus:border-primary-focus focus:outline-hidden focus:ring-2 focus:ring-primary-focus/20 disabled:pointer-events-none disabled:opacity-50"
                        placeholder="Jane">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div
                class="flex flex-col-reverse gap-3 border-t border-card-line bg-muted/30 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <a href="{{ route('grade.index') }}" wire:navigate
                    class="inline-flex items-center justify-center rounded-lg border border-layer-line bg-layer px-4 py-2.5 text-sm font-medium text-layer-foreground shadow-2xs transition hover:bg-layer-hover focus:outline-hidden focus:ring-2 focus:ring-primary-focus/30">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-primary-line bg-primary px-4 py-2.5 text-sm font-medium text-primary-foreground shadow-2xs transition hover:bg-primary-hover focus:outline-hidden focus:ring-2 focus:ring-primary-focus/30 disabled:pointer-events-none disabled:opacity-50">
                    <span wire:loading wire:target="update"
                        class="size-4 animate-spin rounded-full border-2 border-current border-t-transparent"
                        aria-hidden="true"></span>
                    Update grade
                </button>
            </div>
        </form>
    </div>
</div>
