<?php

use App\Models\Grade;
use App\Models\User;

test('add student page uses its Livewire title', function () {
    Grade::factory()->create(['name' => 'Grade 1']);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('student.create'))
        ->assertOk()
        ->assertSee('<title>Student Management | Add Student</title>', false);
});
