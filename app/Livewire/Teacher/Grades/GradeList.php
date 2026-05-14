<?php

namespace App\Livewire\Teacher\Grades;

use App\Models\Grade;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Layout('components.layouts.app')]
class GradeList extends Component
{
    public function delete(int $id): void
    {
        Grade::query()->findOrFail($id)->delete();

        Toaster::success('Grade deleted successfully.');
    }

    public function render()
    {
        return view('livewire.teacher.grades.grade-list', [
            'grades' => Grade::all(),
        ]);
    }
}
