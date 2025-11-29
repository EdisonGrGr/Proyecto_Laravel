<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $doctorFilter = $request->query('doctor');

        $query = Appointment::with('doctor')
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start', '>=', now())
            ->orderBy('start');

        if ($doctorFilter) {
            $query->whereHas('doctor', function ($q) use ($doctorFilter) {
                $q->where('slug', $doctorFilter);
            });
        }

        $upcomingAppointments = $query->take(10)->get();
        
        $stats = [
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')
                ->where('start', '>=', now())
                ->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'rejected' => Appointment::where('status', 'rejected')->count(),
        ];

        $doctors = Doctor::active()->get();

        return inertia('Admin/Home', [
            'stats' => $stats,
            'upcomingAppointments' => $upcomingAppointments,
            'doctors' => $doctors,
        ]);
    }
}
