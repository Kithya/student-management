<?php

use App\Livewire\Admin\Staff\AddStaff;
use App\Livewire\Admin\Staff\EditStaff;
use App\Livewire\Admin\Staff\StaffList;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

test('admin can create teacher staff', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(AddStaff::class)
        ->set('name', 'Teacher One')
        ->set('username', 'teacher-one')
        ->set('role', 'teacher')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirectToRoute('staff.index');

    $this->assertDatabaseHas('users', [
        'name' => 'Teacher One',
        'username' => 'teacher-one',
        'role' => 'teacher',
    ]);
});

test('staff username must be unique', function () {
    $admin = User::factory()->admin()->create();
    User::factory()->teacher()->create(['username' => 'taken']);

    Livewire::actingAs($admin)
        ->test(AddStaff::class)
        ->set('name', 'Teacher Two')
        ->set('username', 'taken')
        ->set('role', 'teacher')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('save')
        ->assertHasErrors(['username']);
});

test('admin can edit staff and optionally update password', function () {
    $admin = User::factory()->admin()->create();
    $teacher = User::factory()->teacher()->create([
        'name' => 'Old Name',
        'username' => 'old-name',
    ]);
    $originalPassword = $teacher->password;

    Livewire::actingAs($admin)
        ->test(EditStaff::class, ['id' => $teacher->id])
        ->set('name', 'New Name')
        ->set('username', 'new-name')
        ->set('role', 'teacher')
        ->call('update')
        ->assertHasNoErrors()
        ->assertRedirectToRoute('staff.index');

    $teacher->refresh();

    expect($teacher->name)->toBe('New Name');
    expect($teacher->username)->toBe('new-name');
    expect($teacher->password)->toBe($originalPassword);

    Livewire::actingAs($admin)
        ->test(EditStaff::class, ['id' => $teacher->id])
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('update')
        ->assertHasNoErrors();

    expect(Hash::check('new-password', $teacher->refresh()->password))->toBeTrue();
});

test('current user cannot be deleted', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(StaffList::class)
        ->call('delete', $admin->id)
        ->assertHasErrors(['staff']);

    expect($admin->fresh())->not->toBeNull();
});

test('last admin cannot be deleted or demoted', function () {
    $admin = User::factory()->admin()->create();
    $teacher = User::factory()->teacher()->create();

    Livewire::actingAs($teacher)
        ->test(StaffList::class)
        ->call('delete', $admin->id)
        ->assertHasErrors(['staff']);

    Livewire::actingAs($admin)
        ->test(EditStaff::class, ['id' => $admin->id])
        ->set('role', 'teacher')
        ->call('update')
        ->assertHasErrors(['role']);

    expect($admin->fresh()->role)->toBe('admin');
});

test('deleting a teacher unassigns their courses', function () {
    $admin = User::factory()->admin()->create();
    $teacher = User::factory()->teacher()->create();
    $grade = Grade::create(['name' => 'Grade 1']);
    $course = Subject::factory()->create([
        'grade_id' => $grade->id,
        'teacher_id' => $teacher->id,
    ]);

    Livewire::actingAs($admin)
        ->test(StaffList::class)
        ->call('delete', $teacher->id)
        ->assertHasNoErrors();

    expect($course->refresh()->teacher_id)->toBeNull();
});
