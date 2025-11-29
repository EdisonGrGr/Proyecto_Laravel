<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    
    public function index()
    {
        $doctors = Doctor::all();
        return inertia('Public/Doctors/Index', compact('doctors'));
    }


    public function showDoctor(Doctor $doctor)
    {
        
        $slots = app('App\Http\Controllers\Api\DoctorController')
                    ->availability($doctor, new Request())
                    ->getData();

        $nextSlots = array_slice($slots, 0, 10);

        return inertia('Public/Doctors/Show', [
            'doctor' => $doctor,
            'nextSlots' => $nextSlots,
        ]);
    }

    
    public function create(Request $request)
    {
        $doctor = Doctor::where('slug', $request->doctor)->firstOrFail();

        $start = Carbon::parse($request->start);
        $duration = (int) env('APPOINTMENT_DURATION_MINUTES', 20);

        return inertia('Public/Appointments/New', [
            'doctor' => $doctor,
            'start' => $start->toIso8601String(),
            'end' => $start->copy()->addMinutes($duration)->toIso8601String(),
        ]);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_name' => 'required|string|min:3',
            'patient_email' => 'required|email',
            'starts_at'     => 'required|date',
        ]);

        $doctor = Doctor::findOrFail($request->doctor_id);

        $duration = (int) env('APPOINTMENT_DURATION_MINUTES', 20);
        $start = Carbon::parse($request->starts_at);
        $end = $start->copy()->addMinutes($duration);

        
        $collision = Appointment::where('doctor_id', $doctor->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('starts_at', '<', $end)
                      ->where('ends_at', '>', $start);
                });
            })
            ->exists();

        if ($collision) {
            return back()->withErrors(['El horario seleccionado ya está ocupado.']);
        }

        
        $appointment = Appointment::create([
            'doctor_id' => $doctor->id,
            'patient_name' => $request->patient_name,
            'patient_email' => $request->patient_email,
            'starts_at' => $start,
            'ends_at' => $end,
            'status' => 'pending',
            'slug' => Str::uuid(),
        ]);

        
        Mail::raw(
            "Hola {$appointment->patient_name}, tu solicitud de cita con el Dr. {$doctor->name} fue registrada en estado PENDIENTE.
Fecha y hora: {$start->format('d-m-Y H:i')}",
            function ($message) use ($appointment) {
                $message->to($appointment->patient_email)
                        ->subject('Solicitud de cita recibida');
            }
        );

        return redirect('/')
            ->with('success', 'Tu cita fue registrada. Revisa tu correo.');
    }
}
