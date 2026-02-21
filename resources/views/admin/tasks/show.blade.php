@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Task Details</h1>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.tasks.edit', $task) }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                Edit
            </a>
            <a href="{{ route('admin.tasks.index') }}" class="inline-flex items-center rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                Back
            </a>
        </div>
    </div>

    <!-- Task Card -->
    <div class="max-w-3xl">
        <div class="rounded-2xl p-8 shadow-2xl transition-all hover:shadow-primary-500/5" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <!-- Top Section: Title and Priority -->
            <div class="flex items-start justify-between gap-4 mb-6">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-white leading-tight">
                        {{ $task->title }}
                    </h2>
                    <p class="mt-3 text-slate-400 leading-relaxed">
                        {{ $task->description }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider
                        @if($task->priority === 'high') bg-red-500/10 text-red-500 border border-red-500/20
                        @elseif($task->priority === 'medium') bg-yellow-500/10 text-yellow-500 border border-yellow-500/20
                        @else bg-blue-500/10 text-blue-500 border border-blue-500/20
                        @endif">
                        {{ $task->priority === 'high' ? 'Urgent' : ucfirst($task->priority) }}
                    </span>
                </div>
            </div>

            <!-- Middle Section: Badges -->
            <div class="flex flex-wrap items-center gap-3 mb-8">
                @if($task->project)
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors" style="background-color: #1A1D24; border: 1px solid #2A2D36; color: #94A3B8;">
                        <span class="w-2 h-2 rounded-full" style="background-color: #3FA9A6;"></span>
                        {{ $task->project->name }}
                    </div>
                @endif
                
                <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium" style="background-color: #1A1D24; border: 1px solid #2A2D36; color: #94A3B8;">
                    Design
                </div>
            </div>

            <!-- Divider -->
            <div class="h-px w-full mb-8" style="background-color: #2A2D36;"></div>

            <!-- Bottom Section: Info and Status -->
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <!-- Date -->
                    <div class="flex items-center gap-2 text-slate-400">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">
                            @if($task->due_date)
                                {{ $task->due_date->isToday() ? 'Today' : $task->due_date->format('M d, Y') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>

                    <!-- Assignee -->
                    <div class="flex items-center gap-2 text-slate-400">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-sm font-medium">{{ $task->user->name }}</span>
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <span class="inline-flex items-center rounded-lg px-4 py-2 text-sm font-semibold transition-all
                        @if($task->status === 'completed') bg-green-500/10 text-green-400 border border-green-500/20
                        @elseif($task->status === 'in_progress') bg-blue-500/10 text-blue-400 border border-blue-500/20
                        @else bg-slate-500/10 text-slate-400 border border-slate-500/20
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    </span>
                </div>
            </div>
            
            @if($task->notes)
                <div class="mt-8 pt-8 border-t border-dashed border-slate-700/50">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Additional Notes</h4>
                    <p class="text-sm text-slate-400 leading-relaxed italic">
                        "{{ $task->notes }}"
                    </p>
                </div>
            @endif

            @if($task->attachment)
                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ Storage::url($task->attachment) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-medium text-white hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.414a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        View Attachment
                    </a>
                </div>
            @endif
        </div>

        <!-- Danger Zone (Delete) -->
        <div class="mt-8 flex justify-end">
            <button type="button" 
                    @click="$dispatch('open-delete-modal', { 
                        action: '{{ route('admin.tasks.destroy', $task) }}',
                        title: 'Delete Task',
                        message: 'Are you sure you want to delete task \'{{ $task->title }}\'?'
                    })"
                    class="text-slate-500 hover:text-red-500 text-sm font-medium transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Delete Task
            </button>
        </div>
    </div>
</div>
@endsection
