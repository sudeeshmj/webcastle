<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_name',
        'phone',
        'appointment_date',
        'doctor_id',
        'slot',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
