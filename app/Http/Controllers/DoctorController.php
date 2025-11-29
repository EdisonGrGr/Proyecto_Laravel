<?php

namespace App\Http\Controllers;

use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        return inertia('Public/Doctors/Index', [
            'doctors' => Doctor::where('active', true)->get()
        ]);
    }

    public function show(Doctor $doctor)
    {
        return inertia('Public/Doctors/Show', [
            'doctor' => $doctor
        ]);
    }
}
