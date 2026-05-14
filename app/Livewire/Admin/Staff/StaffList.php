<?php

namespace App\Livewire\Admin\Staff;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Layout('components.layouts.app')]
class StaffList extends Component
{
    public function delete(int $id): void
    {
        $staff = User::query()
            ->whereIn('role', ['admin', 'teacher'])
            ->findOrFail($id);

        if (Auth::id() === $staff->id) {
            $this->addError('staff', 'You cannot delete your own account.');
            Toaster::error('You cannot delete your own account.');

            return;
        }

        if ($staff->isAdmin() && User::query()->where('role', 'admin')->count() <= 1) {
            $this->addError('staff', 'You cannot delete the last admin.');
            Toaster::error('You cannot delete the last admin.');

            return;
        }

        $staff->assignedSubjects()->update(['teacher_id' => null]);
        $staff->delete();

        Toaster::success('Staff member deleted successfully.');
    }

    public function render(): View
    {
        return view('livewire.admin.staff.staff-list', [
            'staffMembers' => User::query()
                ->whereIn('role', ['admin', 'teacher'])
                ->orderBy('role')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
