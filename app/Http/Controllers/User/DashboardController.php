<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Meeting;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // User-specific statistics
        $myActiveTasks = Task::where('user_id', $userId)
            ->whereIn('status', ['pending', 'in_progress'])
            ->count();
        
        $myCompletedTasks = Task::where('user_id',  $userId)
            ->where('status', 'completed')
            ->count();
        
        $myUrgentTasks = Task::where('user_id', $userId)
            ->where('priority', 'urgent')
            ->count();

        $totalMyTasks = Task::where('user_id', $userId)->count();
        $completionRate = $totalMyTasks > 0 ? round(($myCompletedTasks / $totalMyTasks) * 100) : 0;

        // Recent tasks
        $recentTasks = Task::where('user_id', $userId)
            ->where('is_added', true)
            ->with('project')
            ->latest()
            ->take(10)
            ->get();

        // Upcoming meetings
        $upcomingMeetings = Meeting::where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'myActiveTasks',
            'myCompletedTasks',
            'myUrgentTasks',
            'completionRate',
            'recentTasks',
            'upcomingMeetings'
        ));
    }
}
