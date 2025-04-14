<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;


Route::get('/appointment', [AppointmentController::class, 'doctorList'])->name('doctor.list');
Route::get('/appointment/{doctor}', [AppointmentController::class, 'appointment'])->name('appointment');
Route::post('/book-appointment', [AppointmentController::class, 'bookAppointment'])->name('book.appointment');
Route::post('/get-available-slots', [AppointmentController::class, 'getAvailableSlots']);



Route::middleware(['RedirectIfAuthenticated'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.submit');
});
Route::prefix('admin')->middleware(['auth', 'preventBackHistory'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('doctors', DoctorController::class);
    Route::get('/doctors/{doctor}/availability', [DoctorController::class, 'availability'])->name('doctors.availability');
    Route::post('/doctors/{doctor}/availability', [DoctorController::class, 'storeAvailability'])->name('doctors.availability.store');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
});
