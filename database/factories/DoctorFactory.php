<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DoctorFactory extends Factory
{
    public function definition(): array
    {
        
        $schedule = [
            'monday' => [
                ['start' => '08:00', 'end' => '12:00'],
                ['start' => '14:00', 'end' => '18:00']
            ],
            'tuesday' => [
                ['start' => '08:00', 'end' => '12:00'],
                ['start' => '14:00', 'end' => '18:00']
            ],
            'wednesday' => [
                ['start' => '08:00', 'end' => '12:00'],
                ['start' => '14:00', 'end' => '18:00']
            ],
            'thursday' => [
                ['start' => '08:00', 'end' => '12:00'],
                ['start' => '14:00', 'end' => '18:00']
            ],
            'friday' => [
                ['start' => '08:00', 'end' => '12:00'],
                ['start' => '14:00', 'end' => '18:00']
            ],
            'saturday' => [],
            'sunday' => [],
        ];

        return [
            'name' => $this->faker->name(),
            'slug' => Str::slug($this->faker->unique()->name()),
            'specialty' => 'Oftalmología',
            'weekly_schedule' => $schedule,
            'active' => true,
        ];
    }
}
