<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $doctorSlug = $request->query('doctor');
        $weekStart = $request->query('week') 
            ? Carbon::parse($request->query('week'))->startOfWeek() 
            : Carbon::now()->startOfWeek();

        $weekEnd = $weekStart->copy()->endOfWeek();

        $doctors = Doctor::active()->get();
        
        $query = Appointment::with('doctor')
            ->whereBetween('start', [$weekStart, $weekEnd])
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('start');

        if ($doctorSlug) {
            $query->whereHas('doctor', function ($q) use ($doctorSlug) {
                $q->where('slug', $doctorSlug);
            });
        }

        $appointments = $query->get();

        return inertia('Admin/Calendar', [
            'appointments' => $appointments,
            'doctors' => $doctors,
            'weekStart' => $weekStart->toISOString(),
            'weekEnd' => $weekEnd->toISOString(),
            'selectedDoctor' => $doctorSlug,
        ]);
    }
}
