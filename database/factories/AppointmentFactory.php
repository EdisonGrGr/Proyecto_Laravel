<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 day', '+1 week');
        $end = (clone $start)->modify('+20 minutes');

        return [
            'doctor_id' => Doctor::factory(),
            'slug' => Str::uuid(),
            'patient_name' => $this->faker->name(),
            'patient_email' => $this->faker->safeEmail(),
            'patient_phone' => $this->faker->phoneNumber(),
            'start' => $start,
            'end' => $end,
            'status' => 'pending',
        ];
    }
}
