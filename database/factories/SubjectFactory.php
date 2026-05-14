<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->bothify('SUB-###'),
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'grade_id' => Grade::factory(),
            'teacher_id' => User::factory()->teacher(),
        ];
    }
}
