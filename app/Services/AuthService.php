<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function attemptLogin(array $credentials)
    {
        return Auth::attempt($credentials);
    }
    public function logout()
    {
        Auth::logout();
    }

    public function getAppointmentCount()
    {
        return   Appointment::count();
    }
    public function getDoctorCount()
    {
        return Doctor::count();
    }
}
