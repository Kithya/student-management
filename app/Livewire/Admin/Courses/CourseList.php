<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Layout('components.layouts.app')]
class CourseList extends Component
{
    public function delete(int $id): void
    {
        Subject::query()->findOrFail($id)->delete();

        Toaster::success('Course deleted successfully.');
    }

    public function render(): View
    {
        return view('livewire.admin.courses.course-list', [
            'courses' => Subject::query()
                ->with(['grade', 'teacher'])
                ->orderBy('code')
                ->get(),
        ]);
    }
}
