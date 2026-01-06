<?php

namespace App\Listeners;

use App\Events\AppointmentApproved;
use App\Notifications\AppointmentApprovedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class SendAppointmentApprovedNotificationToPatient
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
    public function handle(AppointmentApproved $event): void
    {
        //
        $appointment = $event->appointment;

        $appointment->load(['doctor', 'patient']);

        $appointment->patient->notify(new AppointmentApprovedNotification($appointment));
    }
}
