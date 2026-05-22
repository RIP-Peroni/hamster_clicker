<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Services\StatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClickController extends Controller
{
    protected $statsService;

    public function __construct(StatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    public function store(Request $request)
    {
        Click::create([
            'user_id' => Auth::id(),
            'clicked_at' => now(),
        ]);

        return redirect()->back();
    }
    
    public function stats(Request $request)
    {
        return response()->json($this->statsService->getUserStats());
    }
}