<?php

namespace App\Livewire\Teacher\Grades;

use App\Models\Grade;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Layout('components.layouts.app')]
class EditGrade extends Component
{
    public $grade_detail;

    public $name;
    public function mount(int $id): void
    {
        $this->grade_detail = Grade::query()->findOrFail($id);

        $this->fill([
            'name' => $this->grade_detail->name,
        ]);
    }

    public function update(): void
    {
        $this->validate([
            'name' => ['required', 'string'],
        ]);

        $this->grade_detail->update([
            'name' => $this->name,
        ]);

        Toaster::success('Grade updated successfully.');

        $this->redirectRoute('grade.index');
    }
    public function render()
    {
        return view('livewire.teacher.grades.edit-grade', [
            
        ]);
    }
}
