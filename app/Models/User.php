<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "role"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // Role check methods
    public function isAdmin()
    {
        return $this->role === "admin";
    }


    public function isDoctor()
    {
        return $this->role === "doctor";
    }

    public function isPatient()
    {
        return $this->role === "patient";
    }




    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }


    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }


    // Get appointments based on user role
    public function appointments()
    {
        if ($this->isPatient()) {
            return $this->patientAppointments();
        } elseif ($this->isDoctor()) {
            return $this->doctorAppointments();
        }

        return collect(); // Empty collection for admin

    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id');
    }


}
