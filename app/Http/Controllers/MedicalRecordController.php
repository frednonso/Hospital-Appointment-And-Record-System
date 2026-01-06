<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMedicalRecordRequest;
use App\Http\Requests\DoctorsMedicalRecordViewRequest;
use App\Services\MedicalRecordService;
use Illuminate\Http\Request;



class MedicalRecordController extends Controller
{
    //

    protected $medicalRecordService;

    public function __construct(MedicalRecordService $medicalRecordService)
    {
        $this->medicalRecordService = $medicalRecordService;

    }

    public function create(CreateMedicalRecordRequest $request)
    {

        $data = $request->validated();

        $response = $this->medicalRecordService->createMedicalRecord($data, $request->user());


        return response()->json([
            "sucess" => true,
            "message" => "medical record created succesfully",
            "data" => $response
        ]);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'diagnosis' => 'sometimes|string|max:500',
            'prescription' => 'sometimes|string|max:1000',
            'symptoms' => 'sometimes|string|max:500',
            'treatment' => 'sometimes|string|max:1000',
            'notes' => 'sometimes|string|max:2000',
            'visit_date' => 'sometimes|date',
        ]);

        $medicalRecord = $this->medicalRecordService->updateMedicalRecord($id, $validated, $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Medical record updated successfully',
            'data' => $medicalRecord
        ], 200);



    }

    public function Doctorsview(DoctorsMedicalRecordViewRequest $request)
    {

        $data = $request->validated();

        $response = $this->medicalRecordService->getPatientRecords($data->patient_id, $request->user());

        return response()->json([
            "sucess" => true,
            "message" => "Patients medical record viewed succesfully",
            "data" => $response
        ]);
    }


    public function Patientsview(Request $request)
    {

        $response = $this->medicalRecordService->getPatientRecords($request->user()->id, $request->user());

        return response()->json([
            "sucess" => true,
            "message" => "Your medical record viewed succesfully",
            "data" => $response
        ]);


    }


}
