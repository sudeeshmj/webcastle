<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Models\Doctor;
use App\Models\DoctorDepartment;
use App\Models\DoctorSchedule;
use App\Services\DoctorService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class DoctorController extends Controller
{
    protected $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function index()
    {
        $doctors = $this->doctorService->getAllDoctors();
        return view('admin.doctors.index', compact('doctors'));
    }


    public function create()
    {
        $departments = $this->doctorService->getAllDepartments();
        return view('admin.doctors.create', compact('departments'));
    }


    public function store(StoreDoctorRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo');
            }

            $this->doctorService->storeDoctor($data);

            return redirect()->route('doctors.index')->with('success', 'Doctor added successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving doctor: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Something went wrong while saving the doctor. Please try again.');
        }
    }


    public function availability(Doctor $doctor)
    {
        $slots = $this->doctorService->generateTimeSlots();
        $schedules = $doctor->schedules->groupBy('day');
        return view('admin.doctors.availability', compact('doctor', 'slots', 'schedules'));
    }


    public function storeAvailability(Request $request, Doctor $doctor)
    {
        try {
            $request->validate([
                'days' => 'nullable|array',
                'days.*' => 'nullable|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'slots' => 'nullable|array',
                'slots.*' => 'nullable|array',
            ]);

            $this->doctorService->storeAvailability($request, $doctor);

            return redirect()->route('doctors.index')->with('success', 'Doctor availability saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving doctor availability: ' . $e->getMessage(), [
                'doctor_id' => $doctor->id,
                'request_data' => $request->all()
            ]);

            return  redirect()->route('doctors.index')->with('error', 'An error occurred while saving availability. Please try again.');
        }
    }
}
