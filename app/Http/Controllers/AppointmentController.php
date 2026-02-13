<?php

namespace App\Http\Controllers;

use App\Http\Requests\Approveappointment;
use App\Http\Requests\BookAppointmentRequest;

use App\Http\Requests\Rejectappointment;
use App\Models\Appointment;
use App\Services\AppointmentService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;





class AppointmentController extends Controller
{
    //
    use ApiResponse;

    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {

        $this->appointmentService = $appointmentService;
    }

    public function book(BookAppointmentRequest $request)
    {
        $data = $request->validated();

        $response = $this->appointmentService->BookAppointment($data);


        return $this->successResponse($response, "appointment booked successfully");
    }

    public function approve(Approveappointment $request, Appointment $appointment)
    {

        // Gate::authorize("update",$appointment);

        $data = $request->validated();

        $response = $this->appointmentService->ApproveAppointment($appointment->id, $data);


        return $this->successResponse($response, "appointment approved succesfully");
    }

    public function reject(Rejectappointment $request, Appointment $appointment)
    {
        $data = $request->validated();

        $response = $this->appointmentService->RejectAppointment($appointment->id, $data);


        return $this->successResponse($response, "appointment rejected succesfully");
    }
}
