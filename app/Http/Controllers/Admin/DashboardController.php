<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Meeting;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTasks = Task::count();
        
        $stats = [
            'active_tasks' => Task::whereIn('status', ['pending', 'in_progress'])->count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
            'urgent_tasks' => Task::where('priority', 'urgent')->count(),
            'total_tasks' => $totalTasks,
        ];

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
            'stats',
            'recentTasks',
            'upcomingMeetings'
        ));
    }
}
