<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    public function definition(): array
    {
        $gender = $this->faker->randomElement(['Male', 'Female']);
        return [
            'first_name'      => $this->faker->firstName($gender),
            'last_name'       => $this->faker->lastName,
            'email'           => $this->faker->unique()->safeEmail,
            'phone'           => $this->faker->phoneNumber,
            'address'         => $this->faker->address,
            'date_of_birth'   => $this->faker->date('Y-m-d', '-18 years'),
            'gender'          => $gender,
            'medical_history' => $this->faker->sentence,
            'allergies'       => $this->faker->word,
        ];
    }
}