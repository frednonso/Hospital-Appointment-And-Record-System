<?php

namespace App\Repositories\Contracts;

interface AppointmentRepositoryInterface
{
    public function book(array $data);

    public function approve(int $id, array $data);

    public function reject(int $id, array $data);

    public function findById(int $id);

}
