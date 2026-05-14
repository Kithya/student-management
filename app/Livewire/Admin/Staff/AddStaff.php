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

#[Title('Staff Management | Add Staff')]
#[Layout('components.layouts.app')]
class AddStaff extends Component
{
    public string $name = '';

    public string $username = '';

    public string $role = 'teacher';

    public string $password = '';

    public string $password_confirmation = '';

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'alpha_dash', 'max:255', 'unique:'.User::class],
            'role' => ['required', Rule::in(['admin', 'teacher'])],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        User::create($validated);

        Toaster::success('Staff member added successfully.');

        $this->redirectRoute('staff.index');
    }

    public function render(): View
    {
        return view('livewire.admin.staff.add-staff');
    }
}
