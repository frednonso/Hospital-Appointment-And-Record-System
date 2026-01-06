<?php

namespace App\Listeners;

use App\Events\AppointmentBooked;
use App\Notifications\NewAppointmentBookedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class SendAppointmentNotificationToDoctor
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppointmentBooked $event): void
    {
        //

        $appointment = $event->appointment;

        // Load the doctor and patient relationships
        $appointment->load(['doctor', 'patient']);


        $appointment->doctor->notify(new NewAppointmentBookedNotification($appointment));
    }


    /**
     * Handle a job failure (optional).
     */
    public function failed(AppointmentBooked $event, \Throwable $exception): void
    {
        // Log the failure
        \Log::error('Failed to send appointment notification', [
            'appointment_id' => $event->appointment->id,
            'error' => $exception->getMessage()
        ]);
    }
}
