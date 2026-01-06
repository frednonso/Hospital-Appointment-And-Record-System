<?php

namespace App\Repositories\Contracts;

interface MedicalRecordRepositoryInterface
{
    public function create(array $data);

    public function update(int $id, array $data);

    public function getPatientRecords(int $patientid);

    public function findById(int $id);

    public function getDoctorCreatedRecords(int $doctorId);

}