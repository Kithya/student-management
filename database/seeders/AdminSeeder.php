<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->firstOrCreate([
            'username' => 'admin',
        ], [
            'name' => 'Admin',
            'role' => 'admin',
            'password' => 'password',
        ]);

        User::query()->firstOrCreate([
            'username' => 'ms-sokha',
        ], [
            'name' => 'Sokha Teacher',
            'role' => 'teacher',
            'password' => 'password',
        ]);

        User::query()->firstOrCreate([
            'username' => 'mr-dara',
        ], [
            'name' => 'Dara Teacher',
            'role' => 'teacher',
            'password' => 'password',
        ]);
    }
}
