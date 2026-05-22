<?php

namespace App\Http\Controllers;

use App\Services\StatsService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $statsService;

    public function __construct(StatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    public function index(Request $request)
    {
        return inertia('Dashboard', [
            'stats' => $this->statsService->getUserStats()
        ]);
    }
}