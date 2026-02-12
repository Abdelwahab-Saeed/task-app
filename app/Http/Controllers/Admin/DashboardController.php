<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Meeting;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate statistics
        $activeTasks = Task::whereIn('status', ['pending', 'in_progress'])->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $urgentTasks = Task::where('priority', 'urgent')->count();
        
        $totalTasks = Task::count();
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // Recent tasks
        $recentTasks = Task::with(['user', 'project'])
            ->latest()
            ->take(5)
            ->get();

        // Upcoming meetings
        $upcomingMeetings = Meeting::where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'activeTasks',
            'completedTasks',
            'urgentTasks',
            'completionRate',
            'recentTasks',
            'upcomingMeetings'
        ));
    }
}
