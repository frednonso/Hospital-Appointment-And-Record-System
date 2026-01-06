<?php

namespace App\Repositories;

use App\Models\MedicalRecord;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;



class MedicalRecordRepository implements MedicalRecordRepositoryInterface
{

    protected $model;

    public function __construct(MedicalRecord $model)
    {
        $this->model = $model;

    }

    public function getDoctorCreatedRecords(int $doctorId){
        return $this->model->where('doctor_id', $doctorId)
            ->with(['patient'])
            ->orderBy('created_at', 'desc')
            ->get();

    }

    public function create(array $data)
    {

        return $this->model->create($data);
    }


    public function update(int $id, array $data)
    {

        $medicalrecord = $this->model->findOrFail($id);



        return $medicalrecord->update($data);

    }


    public function getPatientRecords(int $patientid)
    {
        return $this->model->where('patient_id', $patientid)
        ->orderBy('created_at', 'desc')
        ->get();

    }

    public function findById(int $id) {

        return $this->model->findOrFail($id);
    }

    
}
