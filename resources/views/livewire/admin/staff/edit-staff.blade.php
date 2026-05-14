<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-foreground sm:text-3xl">Edit staff</h1>
            <p class="mt-2 text-sm text-muted-foreground-2">Update account details or reset the password.</p>
        </div>

        <a href="{{ route('staff.index') }}" wire:navigate
            class="inline-flex items-center justify-center rounded-lg border border-layer-line bg-layer px-3 py-2 text-sm font-medium text-layer-foreground shadow-2xs hover:bg-layer-hover">
            Back
        </a>
    </div>

    <form wire:submit="update" class="bg-layer border border-layer-line rounded-lg p-6 shadow-2xs space-y-6">
        <div class="grid gap-5 sm:grid-cols-2">
            <flux:input wire:model="name" label="Name" type="text" required />
            <flux:input wire:model="username" label="Username" type="text" required />
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-foreground">Role</label>
            <select id="role" wire:model="role"
                class="mt-2 block h-10 w-full rounded-lg border border-layer-line bg-layer px-3 text-sm text-foreground shadow-2xs focus:border-primary-focus focus:outline-hidden focus:ring-2 focus:ring-primary-focus/20">
                <option value="teacher">Teacher</option>
                <option value="admin">Admin</option>
            </select>
            @error('role')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <flux:input wire:model="password" label="New password" type="password" autocomplete="new-password" />
            <flux:input wire:model="password_confirmation" label="Confirm new password" type="password" autocomplete="new-password" />
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('staff.index') }}" wire:navigate
                class="inline-flex items-center justify-center rounded-lg border border-layer-line bg-layer px-4 py-2.5 text-sm font-medium text-layer-foreground shadow-2xs hover:bg-layer-hover">
                Cancel
            </a>
            <flux:button variant="primary" type="submit">Update staff</flux:button>
        </div>
    </form>
</div>
