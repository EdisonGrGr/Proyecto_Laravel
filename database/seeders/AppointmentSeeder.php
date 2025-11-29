<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        
        Doctor::all()->each(function ($doctor) {
            Appointment::factory()
                ->count(5)
                ->state(['doctor_id' => $doctor->id])
                ->create();
        });
    }
}
