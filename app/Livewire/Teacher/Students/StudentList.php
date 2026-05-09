<?php

namespace App\Livewire\Teacher\Students;

use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Layout('components.layouts.app')]
class StudentList extends Component
{
    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();

        Toaster::success('Student deleted successfully.');

        return redirect()->route('student.index');
    }

    public function render()
    {
        return view('livewire.teacher.students.student-list', [
            'students' => Student::all(),
        ]);
    }
}
