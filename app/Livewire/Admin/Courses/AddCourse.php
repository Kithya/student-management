<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Course Management | Add Course')]
#[Layout('components.layouts.app')]
class AddCourse extends Component
{
    public string $code = '';

    public string $name = '';

    public string $description = '';

    public string $grade_id = '';

    public string $teacher_id = '';

    public function save(): void
    {
        $validated = $this->validate([
            'code' => ['required', 'string', 'max:255', 'unique:'.Subject::class],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'grade_id' => ['required', 'exists:grades,id'],
            'teacher_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'teacher')),
            ],
        ]);

        $validated['teacher_id'] = $this->teacher_id !== '' ? $this->teacher_id : null;

        Subject::create($validated);

        Toaster::success('Course added successfully.');

        $this->redirectRoute('course.index');
    }

    public function render(): View
    {
        return view('livewire.admin.courses.add-course', [
            'grades' => Grade::query()->orderBy('name')->get(),
            'teachers' => User::query()->where('role', 'teacher')->orderBy('name')->get(),
        ]);
    }
}
