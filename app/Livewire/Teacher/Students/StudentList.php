<?php

namespace App\Livewire\Teacher\Students;

use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Layout('components.layouts.app')]
class StudentList extends Component
{
    public function delete(int $id): void
    {
        Student::query()->findOrFail($id)->delete();

        Toaster::success('Student deleted successfully.');
    }

    public function render()
    {
        return view('livewire.teacher.students.student-list', [
            'students' => Student::query()->with('grade')->orderBy('first_name')->orderBy('last_name')->get(),
        ]);
    }
}
