<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'status',
        'reason',
        'doctor_notes',
        'patient_notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }


    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }


    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', "pending");
    }

    public function scopeApproved($query)
    {
        return $query->where('status', "approved");
    }

    


}
