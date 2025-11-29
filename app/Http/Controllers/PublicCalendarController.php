<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicCalendarController extends Controller
{
    public function week(Request $request, Doctor $doctor)
    {
        $startOfWeek = Carbon::parse($request->get('week', now()))->startOfWeek();
        $endOfWeek = (clone $startOfWeek)->endOfWeek();

        $duration = config('app.appointment_duration', env('APPOINTMENT_DURATION_MINUTES', 20));

        $availability = $this->generateWeeklyAvailability($doctor, $startOfWeek, $endOfWeek, $duration);

        return inertia('Public/Calendar/Week', [
            'doctor' => $doctor,
            'week_start' => $startOfWeek->toDateString(),
            'week_end' => $endOfWeek->toDateString(),
            'availability' => $availability,
            'slot_duration' => $duration
        ]);
    }

    private function generateWeeklyAvailability(Doctor $doctor, $startOfWeek, $endOfWeek, $duration)
    {
        $schedule = $doctor->weekly_schedule;
        $slots = [];

        foreach (Carbon::period($startOfWeek, $endOfWeek) as $day) {

            $dayName = strtolower($day->format('l'));

            if (!isset($schedule[$dayName]) || empty($schedule[$dayName])) {
                continue;
            }

            foreach ($schedule[$dayName] as $range) {

                [$start, $end] = explode('-', $range);

                $startDateTime = Carbon::parse($day->format('Y-m-d') . " " . $start);
                $endDateTime = Carbon::parse($day->format('Y-m-d') . " " . $end);

                $current = clone $startDateTime;

                while ($current->lt($endDateTime)) {
                    $slotStart = clone $current;
                    $slotEnd = (clone $current)->addMinutes($duration);

                    
                    $collision = $doctor->appointments()
                        ->whereIn('status', ['pending', 'confirmed'])
                        ->where(function ($q) use ($slotStart, $slotEnd) {
                            $q->whereBetween('start', [$slotStart, $slotEnd])
                              ->orWhereBetween('end', [$slotStart, $slotEnd])
                              ->orWhere(function ($q) use ($slotStart, $slotEnd) {
                                  $q->where('start', '<=', $slotStart)
                                    ->where('end', '>=', $slotEnd);
                              });
                        })
                        ->exists();

                    if (!$collision) {
                        $slots[] = [
                            'date' => $day->format('Y-m-d'),
                            'start' => $slotStart->format('Y-m-d H:i'),
                            'end'   => $slotEnd->format('Y-m-d H:i')
                        ];
                    }

                    $current->addMinutes($duration);
                }
            }
        }

        return $slots;
    }
}
