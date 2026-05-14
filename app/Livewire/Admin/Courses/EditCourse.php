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

#[Title('Course Management | Edit Course')]
#[Layout('components.layouts.app')]
class EditCourse extends Component
{
    public Subject $course;

    public string $code = '';

    public string $name = '';

    public string $description = '';

    public string $grade_id = '';

    public string $teacher_id = '';

    public function mount(int $id): void
    {
        $this->course = Subject::query()->findOrFail($id);

        $this->fill([
            'code' => $this->course->code,
            'name' => $this->course->name,
            'description' => $this->course->description ?? '',
            'grade_id' => (string) $this->course->grade_id,
            'teacher_id' => $this->course->teacher_id ? (string) $this->course->teacher_id : '',
        ]);
    }

    public function update(): void
    {
        $validated = $this->validate([
            'code' => ['required', 'string', 'max:255', Rule::unique(Subject::class, 'code')->ignore($this->course->id)],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'grade_id' => ['required', 'exists:grades,id'],
            'teacher_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'teacher')),
            ],
        ]);

        $validated['teacher_id'] = $this->teacher_id !== '' ? $this->teacher_id : null;

        $this->course->update($validated);

        Toaster::success('Course updated successfully.');

        $this->redirectRoute('course.index');
    }

    public function render(): View
    {
        return view('livewire.admin.courses.edit-course', [
            'grades' => Grade::query()->orderBy('name')->get(),
            'teachers' => User::query()->where('role', 'teacher')->orderBy('name')->get(),
        ]);
    }
}
