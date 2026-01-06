<?php

namespace App\Providers;

use App\Events\AppointmentApproved;
use App\Events\AppointmentBooked;

use App\Listeners\SendAppointmentApprovedNotificationToPatient;
use App\Listeners\SendAppointmentNotificationToDoctor;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Event::listen(
            AppointmentBooked::class,
            SendAppointmentNotificationToDoctor::class,
        );

        Event::listen(
            AppointmentApproved::class,
            SendAppointmentApprovedNotificationToPatient::class,
        );
    }
}
