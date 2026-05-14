<?php

namespace App\Livewire\Admin\Staff;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Staff Management | Edit Staff')]
#[Layout('components.layouts.app')]
class EditStaff extends Component
{
    public User $staff;

    public string $name = '';

    public string $username = '';

    public string $role = 'teacher';

    public string $password = '';

    public string $password_confirmation = '';

    public function mount(int $id): void
    {
        $this->staff = User::query()
            ->whereIn('role', ['admin', 'teacher'])
            ->findOrFail($id);

        $this->fill([
            'name' => $this->staff->name,
            'username' => $this->staff->username,
            'role' => $this->staff->role,
        ]);
    }

    public function update(): void
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'alpha_dash', 'max:255', Rule::unique(User::class, 'username')->ignore($this->staff->id)],
            'role' => ['required', Rule::in(['admin', 'teacher'])],
        ];

        if ($this->password !== '') {
            $rules['password'] = ['string', 'confirmed', Password::defaults()];
        }

        $validated = $this->validate($rules);

        if ($this->staff->isAdmin() && $validated['role'] !== 'admin' && User::query()->where('role', 'admin')->count() <= 1) {
            $this->addError('role', 'You cannot demote the last admin.');
            Toaster::error('You cannot demote the last admin.');

            return;
        }

        $this->staff->update($validated);

        Toaster::success('Staff member updated successfully.');

        $this->redirectRoute('staff.index');
    }

    public function render(): View
    {
        return view('livewire.admin.staff.edit-staff');
    }
}
