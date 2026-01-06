<?php

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\User;
use App\Repositories\Contracts\DashBoardRepositoryInterface;
use Carbon\Carbon;




class DashboardRepository implements DashBoardRepositoryInterface
{
    public function getUserStats()
    {
        return [
            'total_users' => User::count(),
            'total_doctors' => User::where('role', 'doctor')->count(),
            'total_patients' => User::where('role', 'patient')->count(),
            'new_users_this_month' => User::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
        ];
    }


    public function getAppointmentStats()
    {
        return [
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'approved_appointments' => Appointment::where('status', 'approved')->count(),
            'rejected_appointments' => Appointment::where('status', 'rejected')->count(),
            'appointments_today' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
        ];
    }


    public function getMedicalRecordStats()
    {
        return [
            'total_medical_records' => MedicalRecord::count(),
            'medical_records_this_month' => MedicalRecord::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
        ];
    }


    public function getDoctorAppointmentStats(int $doctorId)
    {
        return [
            'my_total_appointments' => Appointment::where('doctor_id', $doctorId)->count(),
            'pending_appointments' => Appointment::where('doctor_id', $doctorId)
                ->where('status', 'pending')->count(),
            'approved_appointments' => Appointment::where('doctor_id', $doctorId)
                ->where('status', 'approved')->count(),
            'appointments_today' => Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', Carbon::today())->count(),
            'appointments_this_week' => Appointment::where('doctor_id', $doctorId)
                ->whereBetween('appointment_date', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
        ];
    }


    public function getDoctorMedicalRecordStats(int $doctorId)
    {
        return [
            'medical_records_created' => MedicalRecord::where('doctor_id', $doctorId)->count(),
            'medical_records_this_month' => MedicalRecord::where('doctor_id', $doctorId)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
            'total_patients_treated' => MedicalRecord::where('doctor_id', $doctorId)
                ->distinct('patient_id')->count('patient_id'),
        ];
    }


    public function getDoctorPendingAppointments(int $doctorId)
    {
        return Appointment::where('doctor_id', $doctorId)
            ->where('status', 'pending')
            ->with('patient:id,name,email')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
    }


    public function getDoctorTodaysAppointments(int $doctorId)
    {
        return Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', Carbon::today())
            ->with('patient:id,name,email')
            ->orderBy('appointment_time')
            ->get();
    }


    public function getDoctorWeeklySchedule(int $doctorId)
    {
        return Appointment::where('doctor_id', $doctorId)
            ->where('status', 'approved')
            ->whereBetween('appointment_date', [
                Carbon::today(),
                Carbon::today()->addDays(7)
            ])
            ->with('patient:id,name')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get()
            ->groupBy('appointment_date');
    }


    public function getPatientAppointmentStats(int $patientId)
    {
        return [
            'total_appointments' => Appointment::where('patient_id', $patientId)->count(),
            'pending_appointments' => Appointment::where('patient_id', $patientId)
                ->where('status', 'pending')->count(),
            'approved_appointments' => Appointment::where('patient_id', $patientId)
                ->where('status', 'approved')->count(),
        ];
    }

    public function getPatientMedicalRecordStats(int $patientId)
    {
        return [
            'total_medical_records' => MedicalRecord::where('patient_id', $patientId)->count(),
            'medical_records_this_year' => MedicalRecord::where('patient_id', $patientId)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
            'doctors_consulted' => MedicalRecord::where('patient_id', $patientId)
                ->distinct('doctor_id')->count('doctor_id'),
        ];
    }


    public function getPatientUpcomingAppointments(int $patientId, $limit)
    {
        return Appointment::where('patient_id', $patientId)
            ->where('status', 'approved')
            ->where('appointment_date', '>=', Carbon::today())
            ->with('doctor:id,name')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take($limit)
            ->get();
    }


    public function getPatientRecentAppointments(int $patientId, $limit = 5)
    {
        return Appointment::where('patient_id', $patientId)
            ->with('doctor:id,name')
            ->latest()
            ->take($limit)
            ->get();
    }

    





}