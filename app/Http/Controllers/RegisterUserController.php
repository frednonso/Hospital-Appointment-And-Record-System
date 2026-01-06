<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\RegisterUserService;
use Illuminate\Http\Request;


class RegisterUserController extends Controller
{
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

        return response()->json([
            "success" => true,
            "message" => "User Created Successfully",
            "data" => $response
        ]);
    }
}
