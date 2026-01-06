<?php

namespace App\Repositories;

use App\Repositories\Contracts\AppointmentRepositoryInterface;

use App\Models\Appointment;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    protected $model;

    public function __construct(Appointment $model)
    {
        $this->model = $model;

    }


    public function book(array $data)
    {

        return $this->model->create($data);

    }

    public function approve(int $id, array $data)
    {

        $appointment = $this->model->findOrFail($id);

        return $appointment->update($data);

    }

    public function reject(int $id, array $data)
    {
        $appointment = $this->model->findOrFail($id);

        return $appointment->update($data);



    }

    public function findById(int $id) {

        return $this->model->findOrFail($id);
    }


}

