<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorDepartment;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentService
{

    public function getAllAppointments()
    {
        return Appointment::with('doctor')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }
    public function getAllDoctors($request)
    {
        $doctorsQuery = Doctor::orderBy('name');

        if ($request->department) {
            $doctorsQuery->where('doctor_department_id', $request->department);
        }

        return  $doctorsQuery->get();
    }

    public function getAllDepartments()
    {
        return DoctorDepartment::orderBy('name', 'asc')->pluck('name', 'id');
    }
    public function getDoctorAvailableDays($doctorId)
    {
        // return DoctorSchedule::where('doctor_id', $doctorId)
        //     ->select('day')
        //     ->distinct()
        //     ->get();

        return DoctorSchedule::where('doctor_id', $doctorId)
            ->select('day')
            ->distinct()
            ->pluck('day')
            ->toArray();
    }

    public function getAvailableSlots($request)
    {
        $doctorId = $request->doctor_id;
        $date = Carbon::parse($request->date);
        $day = $date->format('l');


        $schedules  = DoctorSchedule::where('doctor_id', $doctorId)
            ->where('day', $day)
            ->get();
        $existingAppointments = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->pluck('slot')->toArray();

        $slots = [];
        $isToday = $date->isToday();
        $currentTime = Carbon::now();

        foreach ($schedules as $schedule) {
            $startTime = Carbon::parse($schedule->start_time);
            $endTime = Carbon::parse($schedule->end_time);

            if ($isToday && $startTime->lt($currentTime)) {
                continue;
            }

            $startFormatted = $startTime->format('h:i A');
            $endFormatted = $endTime->format('h:i A');
            $slotLabel = $startFormatted . ' - ' . $endFormatted;
            $isBooked = in_array($slotLabel, $existingAppointments);

            $slots[] = [
                'time' => $slotLabel,
                'disabled' => $isBooked
            ];
        }


        return response()->json($slots);
    }

    public function bookAppointment($request)
    {

        try {
            $data = $request->validated();
            $exists = Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('slot', $request->slot)
                ->exists();

            if ($exists) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'This time slot is already booked. Please select another one.');
            }

            Appointment::create($data);

            return redirect()->route('doctor.list')
                ->with('success', 'Appointment booked successfully!');
        } catch (\Exception $e) {
            Log::error('Appointment booking failed', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong while booking your appointment. Please try again.');
        }
    }
}
