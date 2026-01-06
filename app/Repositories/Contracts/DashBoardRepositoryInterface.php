<?php

namespace App\Repositories\Contracts;

interface DashBoardRepositoryInterface {

    public function getUserStats();

    public function getAppointmentStats();


    public function getMedicalRecordStats();


    public function getDoctorAppointmentStats(int $doctorId);


    public function getDoctorMedicalRecordStats(int $doctorId);



    public function getDoctorPendingAppointments(int $doctorId);


    public function getDoctorTodaysAppointments(int $doctorId);


    public function getDoctorWeeklySchedule(int $doctorId);


    public function getPatientAppointmentStats(int $patientId);



    public function getPatientMedicalRecordStats(int $patientId);


    public function getPatientUpcomingAppointments(int $patientId, int $limit);


    public function getPatientRecentAppointments(int $patientId, int $limit);


}