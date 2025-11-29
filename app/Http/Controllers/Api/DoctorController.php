<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DoctorController extends Controller
{
    public function availability(Doctor $doctor, Request $request)
    {
        $from = Carbon::parse($request->query('from', now()));
        $to = Carbon::parse($request->query('to', now()->addWeek()));
        $duration = (int) env('APPOINTMENT_DURATION_MINUTES', 20);

        $slots = [];

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereBetween('starts_at', [$from, $to])
            ->get();

        $availability = $doctor->weekly_availability ?? [];

        $map = ['Mon' => 'mon', 'Tue' => 'tue', 'Wed' => 'wed', 'Thu' => 'thu', 'Fri' => 'fri', 'Sat' => 'sat', 'Sun' => 'sun'];

        $period = CarbonPeriod::create($from, $to);
        foreach ($period as $date) {
            $day = $map[$date->format('D')] ?? null;
            if (!$day || !isset($availability[$day])) continue;

            foreach ($availability[$day] as $range) {
                [$startTime, $endTime] = $range;
                $start = Carbon::parse($date->format('Y-m-d') . ' ' . $startTime);
                $end = Carbon::parse($date->format('Y-m-d') . ' ' . $endTime);

                while ($start->addMinutes(0)->lt($end)) {
                    $slotStart = $start->copy();
                    $slotEnd = $start->copy()->addMinutes($duration);

                    if ($slotEnd->gt($end)) break;

                    $collision = $appointments->first(function ($apt) use ($slotStart, $slotEnd) {
                        return $apt->starts_at < $slotEnd && $apt->ends_at > $slotStart;
                    });

                    if (!$collision) {
                        $slots[] = [
                            'start' => $slotStart->toIso8601String(),
                            'end' => $slotEnd->toIso8601String(),
                        ];
                    }

                    $start->addMinutes($duration);
                }
            }
        }

        return response()->json($slots);
    }
}
