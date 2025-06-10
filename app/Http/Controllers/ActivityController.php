<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityUpdate;
use App\Models\DailyActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ActivityController extends Controller
{
    /**
     * Display a listing of activities.
     */
    public function index()
    {
        $activities = Activity::with(['user', 'updates.user', 'dailyLogs.user'])
            ->latest()
            ->get();

        return view('activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create()
    {
        return view('activities.create');
    }

    /**
     * Store a newly created activity in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,done',
            'due_date' => 'required|date',
        ]);

        $activity = Activity::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'user_id' => auth()->id(),
        ]);

        // Create initial activity update
        ActivityUpdate::create([
            'activity_id' => $activity->id,
            'user_id' => auth()->id(),
            'status' => $validated['status'],
            'remark' => 'Activity created'
        ]);

        // Create daily activity log
        DailyActivityLog::create([
            'activity_id' => $activity->id,
            'user_id' => auth()->id(),
            'update_time' => now()
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Activity created successfully',
                'activity' => $activity
            ]);
        }

        return redirect()->route('activities.index')
            ->with('success', 'Activity created successfully.');
    }

    /**
     * Update the status of an activity.
     */
    public function updateStatus(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', ActivityUpdate::getValidStatuses()),
            'remark' => 'required|string',
        ]);

        // Create activity update
        ActivityUpdate::create([
            'activity_id' => $activity->id,
            'user_id' => auth()->id(),
            'status' => $validated['status'],
            'remark' => $validated['remark']
        ]);

        // Update activity status
        $activity->update(['status' => $validated['status']]);

        // Create daily activity log
        DailyActivityLog::create([
            'activity_id' => $activity->id,
            'user_id' => auth()->id(),
            'update_time' => now()
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Activity status updated successfully',
                'activity' => $activity->fresh(['updates.user', 'dailyLogs.user'])
            ]);
        }

        return redirect()->back()->with('success', 'Activity status updated successfully.');
    }

    /**
     * Display daily activities report.
     */
    public function dailyReport(Request $request)
    {
        $date = $request->get('date', Carbon::today());
        $activities = Activity::with(['user', 'updates.user', 'dailyLogs.user'])
            ->whereDate('created_at', $date)
            ->get();

        return view('activities.daily-report', compact('activities', 'date'));
    }

    /**
     * Display custom duration report.
     */
    public function customReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::today()->subDays(7));
        $endDate = $request->get('end_date', Carbon::today());

        $activities = Activity::with(['user', 'updates.user', 'dailyLogs.user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return view('activities.custom-report', compact('activities', 'startDate', 'endDate'));
    }

    public function delete(Request $request, Activity $activity)
    {
        $request->validate([
            'remark' => 'required|string|max:255'
        ]);

        try {
            // Create an activity update to log the deletion
            $update = new ActivityUpdate([
                'activity_id' => $activity->id,
                'status' => 'deleted',
                'remark' => $request->remark,
                'user_id' => auth()->id()
            ]);
            
            $activity->updates()->save($update);

            // Soft delete the activity
            $activity->delete();

            return response()->json([
                'message' => 'Activity deleted successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Activity deletion failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while deleting the activity'
            ], 500);
        }
    }
}
