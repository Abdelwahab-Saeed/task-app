@extends('layouts.user')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold text-white">My Dashboard</h1>
        <p class="mt-1 text-sm text-slate-400">Welcome back, {{ auth()->user()->name }}. Here's your overview for today</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Active Tasks Card -->
        <div class="relative overflow-hidden rounded-xl p-6" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-400">Active Tasks</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $myActiveTasks }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background: linear-gradient(to bottom right, #a855f7, #7c3aed);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Card -->
        <div class="relative overflow-hidden rounded-xl p-6" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-400">Completed</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $myCompletedTasks }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background: linear-gradient(to bottom right, #22c55e, #16a34a);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Urgent Tasks Card -->
        <div class="relative overflow-hidden rounded-xl p-6" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-400">Urgent Tasks</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $myUrgentTasks }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background: linear-gradient(to bottom right, #ef4444, #dc2626);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!--  Completion Rate Card -->
        <div class="relative overflow-hidden rounded-xl p-6" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-400">Completion Rate</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $completionRate }}%</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background: linear-gradient(to bottom right, #5eeee5, #3fa9a6);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- Recent Tasks -->
        <div class="rounded-xl overflow-hidden" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <div class="px-6 py-4 flex items-center justify-between" style="border-bottom: 1px solid #2A2D36;">
                <h2 class="text-lg font-semibold text-white">My Recent Tasks</h2>
                <a href="{{ route('user.tasks.index') }}" class="text-sm font-medium text-primary-400 hover:text-primary-300 transition-colors">View All</a>
            </div>
            <div style="border-top: 1px solid #2A2D36;">
                @forelse($recentTasks as $task)
                    <div class="p-6 hover:bg-opacity-50 transition-colors" style="border-bottom: 1px solid #2A2D36;">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-sm font-medium text-white">{{ $task->title }}</h3>
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold
                                        @if($task->priority === 'urgent') bg-red-500/10 text-red-400 border border-red-500/20
                                        @elseif($task->priority === 'high') bg-orange-500/10 text-orange-400 border border-orange-500/20
                                        @elseif($task->priority === 'medium') bg-yellow-500/10 text-yellow-400 border border-yellow-500/20
                                        @else bg-gray-500/10 text-gray-400 border border-gray-500/20
                                        @endif">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 text-xs text-slate-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $task->due_date->format('M d') }}
                                    </span>
                                    @if($task->project)
                                        <span class="flex items-center gap-1">
                                            <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                                            {{ $task->project->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold
                                @if($task->status === 'completed') bg-green-500/10 text-green-400 border border-green-500/20
                                @elseif($task->status === 'in_progress') bg-blue-500/10 text-blue-400 border border-blue-500/20
                                @else bg-slate-500/10 text-slate-400 border border-slate-500/20
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <p class="text-sm text-slate-400">No recent tasks</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
