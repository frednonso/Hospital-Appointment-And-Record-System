<?php

namespace App\Services;

use App\Models\User;

use App\Models\Appointment;

use App\Models\MedicalRecord;
use App\Repositories\Contracts\DashBoardRepositoryInterface;






use Carbon\Carbon;

use DashboardRepository;
use Illuminate\Support\Facades\DB;


class DashboardService
{

    protected $DashBoardRepository;

    public function __construct(DashBoardRepositoryInterface $DashBoardRepository)
    {

        $this->DashBoardRepository = $DashBoardRepository;

    }

    public function getDashboardData(User $user)
    {
        if ($user->isAdmin()) {
            return $this->getAdminDashboard();
        } elseif ($user->isDoctor()) {
            return $this->getDoctorDashboard($user);
        } elseif ($user->isPatient()) {
            return $this->getPatientDashboard($user);
        }

        throw new \Exception('Invalid user role');

    }

    private function getAdminDashboard()
    {
        return [
            'role' => 'admin',
            'welcome_message' => 'Welcome to Admin Dashboard',
            'statistics' => [

                // // User statistics
                $this->DashBoardRepository->getUserStats(),

                // Appointment statistics

                $this->DashBoardRepository->getAppointmentStats(),

                // Medical records statistics

                $this->DashBoardRepository->getMedicalRecordStats()

            ]

        ];

    }

    private function getDoctorDashboard(User $doctor)
    {
        return [
            'role' => 'doctor',
            'welcome_message' => "Welcome back, Dr. {$doctor->name}",
            'statistics' => [
                // Doctor's appointment statistics
                $this->DashBoardRepository->getDoctorAppointmentStats($doctor->id),
                
                // Medical records statistics

                $this->DashBoardRepository->getDoctorMedicalRecordStats($doctor->id),
                

            ],
            'recent_activities' => [
                // Pending appointments that need attention
                'pending_appointments' => $this->DashBoardRepository->getDoctorPendingAppointments($doctor->id),
                
                // Today's appointments

                'todays_appointments' => $this->DashBoardRepository->getDoctorTodaysAppointments($doctor->id),

                
            ],
            'upcoming_schedule' => [
                // Next 7 days appointments
                'weekly_schedule' =>  $this->DashBoardRepository->getDoctorWeeklySchedule($doctor->id)

            ]
        ];
    }

    private function getPatientDashboard(User $patient)
    {
        return [
            'role' => 'patient',
            'welcome_message' => "Welcome, {$patient->name}",
            'statistics' => [
                // Patient's appointment statistics
                $this->DashBoardRepository->getPatientAppointmentStats($patient->id),
                

                // Medical records statistics
                $this->DashBoardRepository->getPatientMedicalRecordStats($patient->id)
                
            ],
            'recent_activities' => [
                // Upcoming appointments

                'upcoming_appointments' => $this->DashBoardRepository->getPatientUpcomingAppointments($patient->id, 5),
                // Appointment history
                'recent_appointments' => $this->DashBoardRepository->getPatientRecentAppointments($patient->id, 5)
                
            ],
        ];
    }



}