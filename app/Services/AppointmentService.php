<?php

namespace App\Services;

use App\Events\AppointmentApproved;
use App\Events\AppointmentBooked;

use App\Models\Appointment;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;









class AppointmentService
{

    protected $appointmentRepository;


    public function __construct(
        AppointmentRepositoryInterface $appointmentRepository
    ) {

        $this->appointmentRepository = $appointmentRepository;

    }

    public function BookAppointment(array $data)
    {

        if (!Gate::allows('create', Appointment::class)) {
            throw new AuthorizationException('Only patients can book appointments');
        }

        // Validate appointment date is not in the past
        $appointmentDate = Carbon::parse($data['appointment_date']);
        if ($appointmentDate->isPast()) {
            throw new \Exception('Cannot book appointment for past dates');
        }

        // Prepare appointment data
        $appointmentData = [
            'patient_id' => Auth::id(),
            'doctor_id' => $data['doctor_id'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'reason' => $data['reason'] ?? null,
            'status' => 'pending', // Default status
            'doctor_notes' => $data['doctor_notes'] ?? null,
            "patient_notes" => $data['patient_notes'] ?? null
        ];

        $appointment = $this->appointmentRepository->book($appointmentData);

        event(new AppointmentBooked($appointment));

        return $appointment;


    }


    public function ApproveAppointment(int $appointmentId, array $data)
    {

        try {
            $appointment = Appointment::find($appointmentId);

            Gate::authorize('update', $appointment);

            event(new AppointmentApproved($appointment));

            return $this->appointmentRepository->approve($appointmentId, $data);

        } catch (AuthorizationException $e) {
            throw new AuthorizationException('You cannot approve an appointment since you are not a doctor');
        }

    }

    public function RejectAppointment(int $appointmentId, array $data)
    {
        try {
            $appointment = Appointment::find($appointmentId);

            Gate::authorize('update', $appointment);

            return $this->appointmentRepository->reject($appointmentId, $data);

        } catch (AuthorizationException $e) {
            throw new AuthorizationException('You cannot reject an appointment since you are not a doctor');
        }

    }


}