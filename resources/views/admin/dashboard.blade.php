@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold text-black">Dashboard</h1>
        <p class="mt-1 text-sm text-black opacity-60">Welcome back, {{ auth()->user()->name }}. Here's your overview for today</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Active Tasks Card -->
        <div class="relative overflow-hidden rounded-xl p-6 bg-white border border-subtle shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-black opacity-60">Active Tasks</p>
                    <p class="text-3xl font-bold mt-2 text-black">{{ $stats['active_tasks'] }}</p>
                </div>
                <div class="p-3 bg-purple-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completed Card -->
        <div class="relative overflow-hidden rounded-xl p-6 bg-white border border-subtle shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-black opacity-60">Completed</p>
                    <p class="text-3xl font-bold mt-2 text-black">{{ $stats['completed_tasks'] }}</p>
                </div>
                <div class="p-3 bg-green-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Urgent Card -->
        <div class="relative overflow-hidden rounded-xl p-6 bg-white border border-subtle shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-black opacity-60">Urgent Tasks</p>
                    <p class="text-3xl font-bold mt-2 text-black">{{ $stats['urgent_tasks'] }}</p>
                    @if($stats['urgent_tasks'] > 0)
                        <p class="text-xs text-red-500 mt-1 font-medium">Needs attention</p>
                    @endif
                </div>
                <div class="p-3 bg-red-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completion Rate Card -->
        <div class="relative overflow-hidden rounded-xl p-6 bg-white border border-subtle shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-black opacity-60">Completion Rate</p>
                    <p class="text-3xl font-bold mt-2 text-black">
                        {{ $stats['total_tasks'] > 0 ? round(($stats['completed_tasks'] / $stats['total_tasks']) * 100) : 0 }}%
                    </p>
                </div>
                <div class="p-3 bg-primary-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Tasks Table -->
    <div class="mt-8 bg-white rounded-xl border border-subtle shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-subtle bg-slate-50/50">
            <h3 class="text-lg font-bold text-black">Recent Tasks</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-subtle bg-slate-50/30">
                        <th class="px-6 py-4 text-xs font-bold text-black uppercase tracking-wider">Task Info</th>
                        <th class="px-6 py-4 text-xs font-bold text-black uppercase tracking-wider">Project</th>
                        <th class="px-6 py-4 text-xs font-bold text-black uppercase tracking-wider text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-subtle">
                    @forelse($recentTasks as $task)
                        <tr class="hover:bg-slate-50/50 transition-colors" x-data="{ status: '{{ $task->status }}' }">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <div class="text-md font-medium text-black cursor-pointer hover:text-primary-600 transition-colors"
                                            :class="{ 'line-through': status === 'completed' }"
                                            @click="$dispatch('open-edit-modal', { 
                                                url: '{{ route('admin.tasks.edit', $task) }}',
                                                title: 'Edit Task: {{ $task->title }}'
                                            })">
                                            {{ $task->title }}
                                        </div>
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider
                                            @if($task->priority === 'urgent') bg-red-50 text-red-700 border border-red-100
                                            @elseif($task->priority === 'high') bg-orange-50 text-orange-700 border border-orange-100
                                            @elseif($task->priority === 'medium') bg-blue-50 text-blue-700 border border-blue-100
                                            @else bg-slate-50 text-slate-600 border border-soft
                                            @endif">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-3 mt-1 text-xs text-black">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $task->due_date?->format('M d') ?? 'No date' }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ $task->user?->name ?? 'Unassigned' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($task->project)
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-primary-500"></div>
                                        <span class="text-xs font-medium text-black">{{ $task->project->name }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-black italic">No project</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-widest
                                    @if($task->status === 'completed') bg-green-50 text-green-700 border border-green-100
                                    @elseif($task->status === 'in_progress') bg-blue-50 text-blue-700 border border-blue-100
                                    @else bg-slate-50 text-black border border-soft
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center">
                                <p class="text-sm text-black font-medium italic">No recent tasks found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

        <!-- Upcoming Meetings
        <div class="rounded-xl overflow-hidden bg-white border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-50">
                <h2 class="text-lg font-semibold text-black">Upcoming Meetings</h2>
            </div>
            <div style="border-top: 1px solid #2A2D36;">
                @forelse($upcomingMeetings as $meeting)
                    <div class="p-6 hover:bg-opacity-50 transition-colors" style="border-bottom: 1px solid #2A2D36;">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="text-center">
                                    <div class="text-xs text-slate-400">{{ $meeting->scheduled_at->format('h:i A') }}</div>
                                    <div class="text-xs text-slate-500">{{ $meeting->scheduled_at->format('M d') }}</div>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-medium text-slate-900 truncate">{{ $meeting->title }}</h3>
                                <p class="text-xs text-slate-400 mt-1">{{ $meeting->company_name }}</p>
                                @if($meeting->contact_person)
                                    <p class="text-xs text-slate-500 mt-0.5">with {{ $meeting->contact_person }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <p class="text-sm text-slate-400">No upcoming meetings</p>
                    </div>
                @endforelse
            </div>
        </div> -->
    </div>
@endsection
