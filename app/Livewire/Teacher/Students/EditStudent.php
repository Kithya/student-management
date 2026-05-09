<?php

namespace App\Livewire\Teacher\Students;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Student Management | Edit Student')]
#[Layout('components.layouts.app')]
class EditStudent extends Component
{
    public $grades = [];

    public $first_name = '';

    public $last_name = '';

    public $age = '';

    public $grade = '';

    public Student $student;

    public function mount(int $id): void
    {
        $this->student = Student::query()->findOrFail($id);

        $this->fill([
            'first_name' => $this->student->first_name,
            'last_name' => $this->student->last_name,
            'age' => $this->student->age,
            'grade' => $this->student->grade_id,
        ]);

        $this->grades = Grade::query()
            ->orderBy('name')
            ->get();
    }

    public function update(): void
    {
        $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'grade' => ['required', 'exists:grades,id'],
        ]);

        $this->student->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'age' => $this->age,
            'grade_id' => $this->grade,
        ]);

        Toaster::success('Student updated successfully.');

        $this->redirectRoute('student.index');
    }

    public function render(): View
    {
        return view('livewire.teacher.students.edit-student');
    }
}
