<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PublicAppointmentController extends Controller
{
    public function create(Request $request)
    {
        $doctor = Doctor::where('slug', $request->doctor)->firstOrFail();

        return inertia('Public/Appointments/Create', [
            'doctor' => $doctor,
            'start' => $request->start
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_slug' => 'required|exists:doctors,slug',
            'patient_name' => 'required|min:3',
            'patient_email' => 'required|email',
            'start' => 'required|date'
        ]);

        $doctor = Doctor::where('slug', $request->doctor_slug)->firstOrFail();

        $duration = env('APPOINTMENT_DURATION_MINUTES', 20);
        $start = Carbon::parse($request->start);
        $end = (clone $start)->addMinutes($duration);

        
        $conflict = $doctor->appointments()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start', [$start, $end])
                  ->orWhereBetween('end', [$start, $end])
                  ->orWhere(function ($q) use ($start, $end) {
                      $q->where('start', '<=', $start)
                        ->where('end', '>=', $end);
                  });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['start' => 'El horario ya está ocupado.']);
        }

        $appointment = Appointment::create([
            'doctor_id' => $doctor->id,
            'patient_name' => $request->patient_name,
            'patient_email' => $request->patient_email,
            'patient_phone' => $request->patient_phone,
            'start' => $start,
            'end' => $end,
            'status' => 'pending',
        ]);

        

        return redirect('/')->with('success', 'Cita creada correctamente. Espera confirmación.');
    }
}
