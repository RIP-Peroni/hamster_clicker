<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatsService
{
    public function getUserStats($user = null): array
    {
        $user = $user ?? Auth::user();
        $today = Carbon::today();
        $sevenDaysAgo = Carbon::today()->subDays(6);

        $total = $user->clicks()->count();
        $todayCount = $user->clicks()
            ->whereDate('clicked_at', $today)
            ->count();
        
        $last7Days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $sevenDaysAgo->copy()->addDays($i);
            $count = $user->clicks()
                ->whereDate('clicked_at', $date)
                ->count();
            
            $last7Days[] = [
                'date' => $date->format('Y-m-d'),
                'count' => $count
            ];
        }

        return [
            'total' => $total,
            'today' => $todayCount,
            'last7Days' => $last7Days,
        ];
    }
}