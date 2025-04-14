<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\DoctorDepartment;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DoctorService
{

    public function getAllDoctors()
    {
        return  Doctor::with('department')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function getAllDepartments()
    {
        return   DoctorDepartment::orderBy('name', 'asc')->get();
    }
    public function storeDoctor(array $data)
    {
        if (isset($data['photo'])) {
            $file = $data['photo'];
            $filename = Str::slug($data['name']) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/doctors', $filename);
            $data['photo'] = $filename;
        }

        return Doctor::create($data);
    }
    public function generateTimeSlots($start = '07:00', $end = '20:00', $interval = 30)
    {
        $startTime = Carbon::createFromFormat('H:i', $start);
        $endTime = Carbon::createFromFormat('H:i', $end);
        $slots = [];

        while ($startTime->lt($endTime)) {
            $slotStart = $startTime->format('H:i');
            $slotEnd = $startTime->copy()->addMinutes($interval)->format('H:i');
            $slots[] = $slotStart . ' - ' . $slotEnd;
            $startTime->addMinutes($interval);
        }

        return $slots;
    }
    public function storeAvailability($request, Doctor $doctor)
    {
        DoctorSchedule::where('doctor_id', $doctor->id)->delete();

        if ($request->has('days') && is_array($request->days)) {
            foreach ($request->days as $day) {
                if (isset($request->slots[$day])) {
                    foreach ($request->slots[$day] as $slot) {
                        [$startTime, $endTime] = explode(' - ', $slot);

                        DoctorSchedule::create([
                            'doctor_id'  => $doctor->id,
                            'day'        => $day,
                            'start_time' => $startTime,
                            'end_time'   => $endTime,
                        ]);
                    }
                }
            }
        }
    }
}
