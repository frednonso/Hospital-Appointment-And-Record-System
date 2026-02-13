<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\RegisterUserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;



class RegisterUserController extends Controller
{

    use ApiResponse;


    protected $registerService;
    //

    public function __construct(RegisterUserService $registerService)
    {

        $this->registerService = $registerService;
    }

    public function register(StoreUserRequest $request)
    {
        $data = $request->validated();

        $response = $this->registerService->registerUser($data);


        return $this->successResponse($response, "User Created Successfully");
    }
}
