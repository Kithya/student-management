<?php

namespace App\Livewire\Teacher\Grades;

use App\Models\Grade;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Layout('components.layouts.app')]
class GradeList extends Component
{

    public function delete($id)
    {
        $student = Grade::find($id);
        $student->delete();

        Toaster::success('Student deleted successfully.');

        return redirect()->route('grade.index');
    }
    public function render()
    {
        return view('livewire.teacher.grades.grade-list', [
            'grades' => Grade::all(),
        ]);
    }
}
