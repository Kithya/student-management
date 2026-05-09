<?php

use App\Models\User;

test('settings pages render inside the app layout', function (string $path) {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get($path)
        ->assertOk()
        ->assertSee('Student Management')
        ->assertSee('Manage your profile and account settings');
})->with([
    '/settings/profile',
    '/settings/password',
    '/settings/appearance',
]);
