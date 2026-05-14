<?php

use App\Livewire\DashboardWidgetOverview;
use Livewire\Livewire;

test('dashboard widget overview renders with a single Livewire root', function () {
    Livewire::test(DashboardWidgetOverview::class)
        ->assertSee('Total Students')
        ->assertSee('Weekly Attendance Rate')
        ->assertSee('Monthly Attendance');
});
