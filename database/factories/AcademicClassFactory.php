<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicClass>
 */
class AcademicClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $className = fake()->unique()->bothify('Class ?#');
        return [
            'name' => $className,
            'teacher_id' => \App\Models\Teacher::factory(),
            'code' => fake()->unique()->bothify('CLS-####'),
            'description' => fake()->sentence(),
        ];
    }
}
