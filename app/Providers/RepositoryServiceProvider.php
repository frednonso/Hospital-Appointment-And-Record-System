<?php

namespace App\Providers;

use App\Repositories\AppointmentRepository;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Repositories\Contracts\DashBoardRepositoryInterface;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;
use App\Repositories\Contracts\RegisterUserRepositoryInterface;
use App\Repositories\MedicalRecordRepository;
use App\Repositories\RegisterUserRepository;
use DashboardRepository;

use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
        $this->app->bind(MedicalRecordRepositoryInterface::class, MedicalRecordRepository::class);
        $this->app->bind(RegisterUserRepositoryInterface::class, RegisterUserRepository::class);
        $this->app->bind(DashBoardRepositoryInterface::class, DashboardRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
