<?php

namespace Database\Factories;

use App\Models\AcademicClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ClassIds = AcademicClass::pluck('id')->toArray();

        return [
            'name' => fake()->name(),
            'academic_class_id' => fake()->randomElement($ClassIds),
            'nisn' => fake()->unique()->numerify('##########'),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'age' => fake()->numberBetween(10, 18),
            'birth_date' => fake()->dateTimeBetween('-18 years', '-10 years')->format('Y-m-d'),
            'enrollment_date' => fake()->dateTimeBetween('-4 years', 'now')->format('Y-m-d'),
        ];
    }
}
