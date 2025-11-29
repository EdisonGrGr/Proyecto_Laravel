<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        
        Doctor::factory()->create(['name' => 'Dr. Camilo Restrepo']);
        Doctor::factory()->create(['name' => 'Dra. Valentina Gómez']);
        Doctor::factory()->create(['name' => 'Dr. Sergio Medina']);

        
        Doctor::factory(5)->create();
    }
}
