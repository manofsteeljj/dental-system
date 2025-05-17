<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\User;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        $patientId = Patient::inRandomOrder()->value('id');
        $procedureId = Procedure::inRandomOrder()->value('id');
        $userId = User::inRandomOrder()->value('id');

        // Fallback if no records exist
        if (!$patientId || !$procedureId || !$userId) {
            throw new \Exception('Related models (Patient, Procedure, User) must exist before seeding Appointments.');
        }

        $date = $this->faker->dateTimeBetween('now', '+1 month');
        $start = $this->faker->dateTimeBetween($date->format('Y-m-d') . ' 08:00:00', $date->format('Y-m-d') . ' 16:00:00');
        $duration = $this->faker->numberBetween(30, 120);
        $end = (clone $start)->modify("+$duration minutes");

        return [
            'patient_id' => $patientId,
            'procedure_id' => $procedureId,
            'user_id' => $userId,
            'appointment_date' => $start->format('Y-m-d'),
            'start_time' => $start,
            'end_time' => $end,
            'status' => $this->faker->randomElement(['scheduled', 'confirmed', 'cancelled']),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}