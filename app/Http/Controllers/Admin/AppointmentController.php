<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmed;
use App\Mail\AppointmentRejected;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with('doctor')->orderBy('start', 'asc');

        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('doctor')) {
            $query->whereHas('doctor', function ($q) use ($request) {
                $q->where('slug', $request->doctor);
            });
        }

        $appointments = $query->paginate(20);
        $doctors = Doctor::active()->get();

        return inertia('Admin/Appointments/Index', [
            'appointments' => $appointments,
            'doctors' => $doctors,
            'filters' => $request->only(['status', 'doctor']),
        ]);
    }

    public function show(Appointment $appointment)
    {
        $appointment->load('doctor');
        
        return inertia('Admin/Appointments/Show', [
            'appointment' => $appointment,
        ]);
    }

    public function edit(Appointment $appointment)
    {
        $appointment->load('doctor');
        $doctors = Doctor::active()->get();

        return inertia('Admin/Appointments/Edit', [
            'appointment' => $appointment,
            'doctors' => $doctors,
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email',
            'patient_phone' => 'nullable|string|max:20',
            'status' => 'required|in:pending,confirmed,completed,rejected',
        ]);

        $appointment->update($validated);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Cita actualizada exitosamente.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Cita eliminada exitosamente.');
    }

    public function accept(Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return back()->withErrors(['error' => 'Solo se pueden aceptar citas pendientes.']);
        }

        $appointment->status = 'confirmed';
        $appointment->save();

        try {
            Mail::to($appointment->patient_email)->send(new AppointmentConfirmed($appointment));
        } catch (\Exception $e) {
            \Log::error('Failed to send confirmation email: ' . $e->getMessage());
        }

        return back()->with('success', 'Cita aceptada y confirmación enviada al paciente.');
    }

    public function reject(Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return back()->withErrors(['error' => 'Solo se pueden rechazar citas pendientes.']);
        }

        $appointment->status = 'rejected';
        $appointment->save();

        try {
            Mail::to($appointment->patient_email)->send(new AppointmentRejected($appointment));
        } catch (\Exception $e) {
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }

        return back()->with('success', 'Cita rechazada y notificación enviada al paciente.');
    }

    public function complete(Appointment $appointment)
    {
        if ($appointment->status !== 'confirmed') {
            return back()->withErrors(['error' => 'Solo se pueden completar citas confirmadas.']);
        }

        $appointment->status = 'completed';
        $appointment->save();

        return back()->with('success', 'Cita marcada como completada.');
    }
}
