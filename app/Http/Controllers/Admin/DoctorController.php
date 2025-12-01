<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::orderBy('name')->paginate(15);
        
        return inertia('Admin/Doctors/Index', [
            'doctors' => $doctors,
        ]);
    }

    public function create()
    {
        return inertia('Admin/Doctors/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'weekly_schedule' => 'required|array',
            'active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Doctor::create($validated);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Médico creado exitosamente.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['appointments' => function ($query) {
            $query->orderBy('start', 'desc')->take(20);
        }]);

        return inertia('Admin/Doctors/Show', [
            'doctor' => $doctor,
        ]);
    }

    public function edit(Doctor $doctor)
    {
        return inertia('Admin/Doctors/Edit', [
            'doctor' => $doctor,
        ]);
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'weekly_schedule' => 'required|array',
            'active' => 'boolean',
        ]);

        if ($validated['name'] !== $doctor->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Médico actualizado exitosamente.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Médico eliminado exitosamente.');
    }
}
