@extends('layouts.user')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">My Tasks</h1>
            <p class="mt-1 text-sm text-slate-400">View and track your assigned tasks</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg" style="background-color: #22252E; border: 1px solid #2A2D36;">
        <form method="GET" action="{{ route('user.tasks.index') }}" class="p-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..." class="block w-full rounded-md border-0 py-1.5 px-3 text-white shadow-sm ring-1 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #1A1D24; border-color: #2A2D36; color: white;" />
                </div>
                <div>
                    <select name="status" class="block w-full rounded-md border-0 py-1.5 px-3 text-white" style="background-color: #1A1D24; border-color: #2A2D36; shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div>
                    <select name="priority" class="block w-full rounded-md border-0 py-1.5 px-3 text-white" style="background-color: #1A1D24; border-color: #2A2D36; shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                        <option value="">All Priorities</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                        Filter
                    </button>
                    <a href="{{ route('user.tasks.index') }}" class="flex-1 text-center rounded-md bg-[#1A1D24] px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tasks Table -->
    <div class="shadow overflow-hidden rounded-lg" style="background-color: #22252E; border: 1px solid #2A2D36;">
        <table class="min-w-full" style="border-top: 1px solid #2A2D36;">
            <thead style="background-color: #1A1D24;">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Task</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Project</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Due Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Priority</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody style="background-color: #22252E;">
                @forelse($tasks as $task)
                    <tr class="hover:bg-opacity-50" style="border-bottom: 1px solid #2A2D36;">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-white">{{ $task->title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-400">{{ $task->project?->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-300">{{ $task->due_date->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                @if($task->status === 'completed') bg-green-500/10 text-green-400 border border-green-500/20
                                @elseif($task->status === 'in_progress') bg-blue-500/10 text-blue-400 border border-blue-500/20
                                @else bg-slate-500/10 text-slate-400 border border-slate-500/20
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                @if($task->priority === 'urgent') bg-red-500/10 text-red-400 border border-red-500/20
                                @elseif($task->priority === 'high') bg-orange-500/10 text-orange-400 border border-orange-500/20
                                @elseif($task->priority === 'medium') bg-yellow-500/10 text-yellow-400 border border-yellow-500/20
                                @else bg-gray-500/10 text-gray-400 border border-gray-500/20
                                @endif">
                                {{ $task->priority === 'urgent' ? 'Urgent' : ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('user.tasks.show', $task) }}" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700/50 rounded-lg transition-colors inline-flex items-center gap-2" title="View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>Details</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                            No tasks assigned to you.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($tasks->hasPages())
            <div class="px-6 py-4 border-t border-[#2A2D36]">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
