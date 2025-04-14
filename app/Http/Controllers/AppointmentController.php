<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Services\AppointmentService;
use Illuminate\Http\Request;


class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }


    public function index()
    {
        $appointments = $this->appointmentService->getAllAppointments();
        return view('admin.appointments.index', compact('appointments'));
    }

    public function doctorList(Request $request)
    {
        $departments = $this->appointmentService->getAllDepartments();
        $doctors = $this->appointmentService->getAllDoctors($request);
        return view('appointments.index', compact('doctors', 'departments'));
    }

    public function appointment(Doctor $doctor)
    {
        $doctorAvailableDays = $this->appointmentService->getDoctorAvailableDays($doctor->id);
        return view('appointments.book-appointment', compact('doctor', 'doctorAvailableDays'));
    }

    public function getAvailableSlots(Request $request)
    {
        return $this->appointmentService->getAvailableSlots($request);
    }

    public function bookAppointment(AppointmentRequest $request)
    {
        return $this->appointmentService->bookAppointment($request);
    }
}
