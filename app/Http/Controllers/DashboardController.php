<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }


    public function index()
    {

        $dasbBoardData = $this->dashboardService->getDashboardData(Auth::user());

        return response()->json([
            'success' => true,
            "message" => "Dashboard retrieved successfully",
            'data' => $dasbBoardData
        ]);

    }


}
