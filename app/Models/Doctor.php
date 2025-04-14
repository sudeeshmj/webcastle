<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'doctor_department_id',
        'qualification',
        'phone',
        'gender',
        'email',
        'photo',
        'status'
    ];

    public function department()
    {
        return $this->belongsTo(DoctorDepartment::class, 'doctor_department_id');
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
