<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

test('removed authentication routes are absent', function () {
    expect(Route::has('password.request'))->toBeFalse();
    expect(Route::has('password.reset'))->toBeFalse();
    expect(Route::has('verification.notice'))->toBeFalse();
    expect(Route::has('verification.verify'))->toBeFalse();

    $this->get('/forgot-password')->assertNotFound();
    $this->get('/reset-password/token')->assertNotFound();
    $this->get('/verify-email')->assertNotFound();
});

test('users table uses username identity only', function () {
    expect(Schema::hasColumn('users', 'username'))->toBeTrue();
    expect(Schema::hasColumn('users', 'email'))->toBeFalse();
    expect(Schema::hasColumn('users', 'email_verified_at'))->toBeFalse();
    expect(Schema::hasTable('password_reset_tokens'))->toBeFalse();
});
