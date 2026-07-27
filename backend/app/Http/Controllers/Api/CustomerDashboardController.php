<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Dashboard\Application\Services\CustomerDashboardService;

class CustomerDashboardController extends Controller
{
    public function __construct(
        private readonly CustomerDashboardService $dashboardService
    ) {}

    public function index(Request $request)
    {
        return response()->json(
            $this->dashboardService->getDashboardData($request->user())
        );
    }
}
