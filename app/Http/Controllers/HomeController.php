<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = Carbon::today();
        
        $activities = Activity::with(['user', 'updates.user', 'dailyLogs.user'])
            ->latest()
            ->get();

        $completedCount = $activities->where('status', 'done')->count();
        $pendingCount = $activities->where('status', 'pending')->count();
        $todayCount = $activities->filter(function ($activity) use ($today) {
            return Carbon::parse($activity->created_at)->isSameDay($today);
        })->count();

        return view('home', compact('activities', 'completedCount', 'pendingCount', 'todayCount'));
    }
}
