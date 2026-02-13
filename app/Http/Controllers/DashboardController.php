<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    //
    use ApiResponse;


    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }


    public function index()
    {

        $dasbBoardData = $this->dashboardService->getDashboardData(Auth::user());


        return $this->successResponse($dasbBoardData, "Dashboard retrieved successfully");
    }
}
