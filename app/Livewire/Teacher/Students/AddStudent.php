<?php

namespace App\Livewire\Teacher\Students;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Student Management | Add Student')]
#[Layout('components.layouts.app')]
class AddStudent extends Component
{
    public $grades = [];

    public $first_name = '';

    public $last_name = '';

    public $age = '';

    public $grade = '';

    public function mount(): void
    {
        $this->grades = Grade::query()
            ->orderBy('name')
            ->get();
    }

    public function save(): void
    {
        $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'grade' => ['required', 'exists:grades,id'],
        ]);

        Student::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'age' => $this->age,
            'grade_id' => $this->grade,
        ]);

        $this->reset();

        Toaster::success('Student added successfully.');

        $this->redirectRoute('student.index');
    }

    public function render(): View
    {
        return view('livewire.teacher.students.add-student');
    }
}
