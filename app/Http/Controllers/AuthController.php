<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    //
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

        return response()->json([
            "success" => true,
            "message" => "User logged In",
            "Data" => $result
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json([
            "success" => true,
            'message' => 'Logged out from all devices'
        ]);
    }
}
