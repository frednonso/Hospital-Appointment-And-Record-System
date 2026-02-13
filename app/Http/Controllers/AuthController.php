<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;



class AuthController extends Controller
{
    //

    use ApiResponse;


    protected $authService;

    public function __construct(AuthService $authService)
    {

        $this->authService = $authService;
    }


    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $result = $this->authService->login($data);


        return $this->successResponse($result, "User logged In");
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());


        return $this->successResponse(null, 'Logged out from all devices');
    }
}
