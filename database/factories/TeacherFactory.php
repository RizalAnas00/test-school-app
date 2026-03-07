<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'subject' => fake()->randomElement(['Mathematics', 'Science', 'History', 'Literature', 'Physical Education']),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'birth_date' => fake()->dateTimeBetween('-55 years', '-25 years')->format('Y-m-d'),
        ];
    }
}
