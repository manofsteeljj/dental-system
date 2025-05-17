<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProcedureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Dental Check-up',
                'Tooth Extraction',
                'Teeth Cleaning',
                'Dental Filling',
                'Root Canal',
                'Braces Consultation',
                'Teeth Whitening',
            ]),
            'description' => $this->faker->sentence(8),
            'cost' => $this->faker->randomFloat(2, 500, 5000),
            'duration' => $this->faker->numberBetween(20, 120), // in minutes
        ];
    }
}