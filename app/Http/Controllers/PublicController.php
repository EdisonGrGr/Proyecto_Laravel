<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentCreated;

class PublicController extends Controller
{
    public function index()
    {
        $doctors = Doctor::active()->get();
        return inertia('Public/Index', compact('doctors'));
    }

    public function show(Doctor $doctor)
    {
        
        $doctor->load(['appointments' => function ($query) {
            $query->whereIn('status', ['pending', 'confirmed'])
                  ->where('start', '>=', now())
                  ->orderBy('start');
        }]);

        return inertia('Public/DoctorProfile', compact('doctor'));
    }

    public function newAppointment(Request $request)
    {
        
        $doctor = Doctor::where('slug', $request->query('doctor'))->firstOrFail();
        $start = Carbon::parse($request->query('start'));
        
        return inertia('Public/NewAppointment', compact('doctor', 'start'));
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email',
            'patient_phone' => 'nullable|string|max:20',
            'start' => 'required|date',
        ]);

        $doctor = Doctor::findOrFail($validated['doctor_id']);
        $start = Carbon::parse($validated['start']);
        $duration = (int) env('APPOINTMENT_DURATION_MINUTES', 20);
        $end = $start->copy()->addMinutes($duration);

        
        if (!$this->isWithinWeeklyAvailability($doctor, $start, $end)) {
            return back()->withErrors(['start' => 'El horario seleccionado no está dentro de la disponibilidad del médico.'])->withInput();
        }

        
        $collision = Appointment::where('doctor_id', $doctor->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start', [$start, $end->copy()->subSecond()])
                    ->orWhereBetween('end', [$start->copy()->addSecond(), $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start', '<', $start)->where('end', '>', $start);
                    });
            })
            ->exists();

        if ($collision) {
            return back()->withErrors(['start' => 'El horario ya está reservado o en espera para este médico.'])->withInput();
        }

        
        $appointment = Appointment::create([
            'doctor_id' => $doctor->id,
            'patient_name' => $validated['patient_name'],
            'patient_email' => $validated['patient_email'],
            'patient_phone' => $validated['patient_phone'] ?? null,
            'start' => $start,
            'end' => $end,
            'status' => 'pending',
        ]);

        
        try {
            Mail::to($appointment->patient_email)->send(new AppointmentCreated($appointment));
        } catch (\Exception $e) {
            
            \Log::error('Failed to send appointment email: ' . $e->getMessage());
        }

        return redirect()->route('public.index')->with('success', 'Cita solicitada exitosamente. Recibirás un correo de confirmación.');
    }

    protected function isWithinWeeklyAvailability(Doctor $doctor, Carbon $start, Carbon $end): bool
    {
        $dayOfWeek = strtolower($start->format('l')); 
        $schedule = $doctor->weekly_schedule ?? [];

        \Log::info('Checking availability', [
            'day' => $dayOfWeek,
            'start' => $start->format('Y-m-d H:i:s'),
            'end' => $end->format('Y-m-d H:i:s'),
            'schedule' => $schedule
        ]);

        if (!isset($schedule[$dayOfWeek]) || empty($schedule[$dayOfWeek])) {
            \Log::info('No schedule for day: ' . $dayOfWeek);
            return false;
        }

        $timeStart = $start->format('H:i');
        $timeEnd = $end->format('H:i');

        \Log::info('Time comparison', [
            'timeStart' => $timeStart,
            'timeEnd' => $timeEnd,
            'slots' => $schedule[$dayOfWeek]
        ]);

        foreach ($schedule[$dayOfWeek] as $slot) {
            \Log::info('Comparing slot', [
                'slot_start' => $slot['start'],
                'slot_end' => $slot['end'],
                'check_start' => $timeStart >= $slot['start'],
                'check_end' => $timeEnd <= $slot['end']
            ]);
            
            if ($timeStart >= $slot['start'] && $timeEnd <= $slot['end']) {
                return true;
            }
        }

        return false;
    }
}
