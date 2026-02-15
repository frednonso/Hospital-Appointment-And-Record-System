<?php

namespace App\Services;

use App\Models\MedicalRecord;
use App\Models\User;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;





class MedicalRecordService
{

    protected $medicalRecordRepository;

    public function __construct(MedicalRecordRepositoryInterface $medicalRecordRepository)
    {

        $this->medicalRecordRepository = $medicalRecordRepository;


    }


    public function createMedicalRecord(array $data, User $user)
    {

        // Create medical record - Only doctors can create 
        // use gate

        if (!$user->can('create', MedicalRecord::class)) {
            throw new AuthorizationException('Only doctors can create medical records');
        }

        if (isset($data['attachment'])) {
            $path = \Illuminate\Support\Facades\Storage::disk('public')->put('medical_records', $data['attachment']);
            $data['attachment_path'] = $path;
            unset($data['attachment']);
        }

        $data["doctor_id"] = $user->id;

        return $this->medicalRecordRepository->create($data);
    }


    public function updateMedicalRecord(int $recordId, array $data, User $user)
    {
        // update medical record - Only doctors can create 
        $record = $this->medicalRecordRepository->findById($recordId);

        if (!$user->can('update', $record)) {
            throw new AuthorizationException(
                'Only the doctor can update it'
            );
        }





        return $this->medicalRecordRepository->update($recordId, $data);


    }

    public function getPatientRecords(int $patientid, User $user)
    {

        $records = $this->medicalRecordRepository->getPatientRecords($patientid);

        // For each record, apply the policy check
        $records = $records->filter(function ($record) use ($user) {
            return $user->can('view', $record);
        });


        // If no records pass the policy check, throw exception
        if ($records->isEmpty() && $this->medicalRecordRepository->getPatientRecords($patientid)->isNotEmpty()) {
            throw new AuthorizationException(
                'You are not authorized to view these records'
            );
        }



        return $records;

    }





}