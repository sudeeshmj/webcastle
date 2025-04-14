<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function handleLogin(LoginRequest $request)
    {

        $credentials = $request->validated();

        if ($this->authService->attemptLogin($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withInput()->with('message', 'Email or Password is Invalid.');
    }

    public function admindashboard()
    {
        $appointmentCount = $this->authService->getAppointmentCount();
        $doctorCount =  $this->authService->getDoctorCount();
        return view('admin.dashboard', compact('appointmentCount', 'doctorCount'));
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('login');
    }
}
