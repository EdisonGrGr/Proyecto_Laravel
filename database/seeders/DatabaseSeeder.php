<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@oftalmo.ucaldas.edu.co',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        
        $schedule1 = [
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

        $schedule2 = [
            'monday' => [
                ['start' => '09:00', 'end' => '13:00'],
                ['start' => '15:00', 'end' => '19:00']
            ],
            'tuesday' => [
                ['start' => '09:00', 'end' => '13:00'],
                ['start' => '15:00', 'end' => '19:00']
            ],
            'wednesday' => [
                ['start' => '09:00', 'end' => '13:00']
            ],
            'thursday' => [
                ['start' => '09:00', 'end' => '13:00'],
                ['start' => '15:00', 'end' => '19:00']
            ],
            'friday' => [
                ['start' => '09:00', 'end' => '13:00'],
                ['start' => '15:00', 'end' => '19:00']
            ],
            'saturday' => [
                ['start' => '09:00', 'end' => '12:00']
            ],
            'sunday' => [],
        ];

        $schedule3 = [
            'monday' => [
                ['start' => '10:00', 'end' => '14:00'],
                ['start' => '16:00', 'end' => '20:00']
            ],
            'tuesday' => [
                ['start' => '10:00', 'end' => '14:00'],
                ['start' => '16:00', 'end' => '20:00']
            ],
            'wednesday' => [
                ['start' => '10:00', 'end' => '14:00'],
                ['start' => '16:00', 'end' => '20:00']
            ],
            'thursday' => [
                ['start' => '10:00', 'end' => '14:00']
            ],
            'friday' => [
                ['start' => '10:00', 'end' => '14:00'],
                ['start' => '16:00', 'end' => '20:00']
            ],
            'saturday' => [],
            'sunday' => [],
        ];

        $doctor1 = Doctor::create([
            'name' => 'Dr. Juan Pérez',
            'slug' => 'dr-juan-perez',
            'specialty' => 'Oftalmología',
            'weekly_schedule' => $schedule1,
            'active' => true,
        ]);

        $doctor2 = Doctor::create([
            'name' => 'Dra. María García',
            'slug' => 'dra-maria-garcia',
            'specialty' => 'Oftalmología',
            'weekly_schedule' => $schedule2,
            'active' => true,
        ]);

        $doctor3 = Doctor::create([
            'name' => 'Dr. Carlos Rodríguez',
            'slug' => 'dr-carlos-rodriguez',
            'specialty' => 'Oftalmología',
            'weekly_schedule' => $schedule3,
            'active' => true,
        ]);

        
        $duration = (int) env('APPOINTMENT_DURATION_MINUTES', 20);
        
        
        $nextMonday = Carbon::now()->next('Monday')->setTime(8, 0);
        Appointment::create([
            'doctor_id' => $doctor1->id,
            'patient_name' => 'Ana Martínez',
            'patient_email' => 'ana@example.com',
            'patient_phone' => '555-0101',
            'start' => $nextMonday,
            'end' => $nextMonday->copy()->addMinutes($duration),
            'status' => 'pending',
        ]);

        Appointment::create([
            'doctor_id' => $doctor1->id,
            'patient_name' => 'Pedro López',
            'patient_email' => 'pedro@example.com',
            'patient_phone' => '555-0102',
            'start' => $nextMonday->copy()->addMinutes($duration),
            'end' => $nextMonday->copy()->addMinutes($duration * 2),
            'status' => 'confirmed',
        ]);

        
        $nextTuesday = Carbon::now()->next('Tuesday')->setTime(9, 0);
        Appointment::create([
            'doctor_id' => $doctor2->id,
            'patient_name' => 'Laura Sánchez',
            'patient_email' => 'laura@example.com',
            'patient_phone' => '555-0103',
            'start' => $nextTuesday,
            'end' => $nextTuesday->copy()->addMinutes($duration),
            'status' => 'pending',
        ]);

        
        $nextWednesday = Carbon::now()->next('Wednesday')->setTime(10, 0);
        Appointment::create([
            'doctor_id' => $doctor3->id,
            'patient_name' => 'Roberto Díaz',
            'patient_email' => 'roberto@example.com',
            'patient_phone' => '555-0104',
            'start' => $nextWednesday,
            'end' => $nextWednesday->copy()->addMinutes($duration),
            'status' => 'confirmed',
        ]);
    }
}
