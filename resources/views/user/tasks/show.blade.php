@extends('layouts.user')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">Task Details</h1>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('user.tasks.index') }}" class="inline-flex items-center rounded-md bg-[#1A1D24] px-4 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                <svg class="-ml-1 mr-2 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <!-- Task Card -->
    <div class="max-w-4xl">
        <div class="rounded-2xl p-8 shadow-2xl" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <!-- Top Section: Title and Priority -->
            <div class="flex items-start justify-between gap-4 mb-6">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-white leading-tight">
                        {{ $task->title }}
                    </h2>
                </div>
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider
                        @if($task->priority === 'urgent') bg-red-500/10 text-red-500 border border-red-500/20
                        @elseif($task->priority === 'high') bg-orange-500/10 text-orange-500 border border-orange-500/20
                        @elseif($task->priority === 'medium') bg-yellow-500/10 text-yellow-500 border border-yellow-500/20
                        @else bg-blue-500/10 text-blue-500 border border-blue-500/20
                        @endif">
                        {{ ucfirst($task->priority) }}
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
                
                <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium" style="background-color: #1A1D24; border: 1px solid #2A2D36; color: #3FA9A6;">
                    #{{ $task->id }}
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Description</h4>
                <div class="text-slate-300 leading-relaxed prose dark:prose-invert max-w-none">
                    {!! nl2br(e($task->description)) !!}
                </div>
            </div>

            <!-- Divider -->
            <div class="h-px w-full mb-8" style="background-color: #2A2D36;"></div>

            <!-- Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-slate-800/50">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Due Date</p>
                            <p class="text-sm font-semibold text-white">{{ $task->due_date?->format('F d, Y') ?? 'N/A' }}</p>
                        </div>
                    </div>

                    @if($task->reminder_date)
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-slate-800/50">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Reminder</p>
                            <p class="text-sm font-semibold text-white">{{ $task->reminder_date?->format('F d, Y') ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="flex flex-col justify-center">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Update Status</h4>
                    <form action="{{ route('user.tasks.update-status', $task) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" 
                                class="flex-1 rounded-lg border-0 py-2 px-3 text-sm text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 transition-all cursor-pointer">
                            <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center
                            @if($task->status === 'completed') bg-green-500/10 text-green-400
                            @elseif($task->status === 'in_progress') bg-blue-500/10 text-blue-400
                            @else bg-slate-500/10 text-slate-400
                            @endif">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </form>
                </div>
            </div>
            
            @if($task->notes)
                <div class="pt-8 border-t border-dashed border-slate-700/50">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Additional Notes</h4>
                    <p class="text-sm text-slate-400 leading-relaxed bg-[#1A1D24] p-4 rounded-xl border border-[#2A2D36]">
                        {{ $task->notes }}
                    </p>
                </div>
            @endif

            @if($task->attachment)
                <div class="mt-8 flex items-center justify-between p-4 rounded-xl bg-primary-500/5 border border-primary-500/10">
                    <div class="flex items-center gap-3 text-slate-300">
                        <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.414a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        <span class="text-sm font-medium">Task Attachment</span>
                    </div>
                    <a href="{{ Storage::url($task->attachment) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-200 hover:text-slate-400">
                        View File
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
