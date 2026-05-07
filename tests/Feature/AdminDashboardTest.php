<?php

use App\Models\User;

test('admin dashboard is displayed', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $this->actingAs($user);

    $this->get('/admin/dashboard')->assertOk();
});
