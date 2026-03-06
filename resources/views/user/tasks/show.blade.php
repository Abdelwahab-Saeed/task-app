@extends('layouts.user')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Task Details</h1>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('user.tasks.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-semibold text-black shadow-sm border border-subtle hover:bg-slate-200 transition-all">
                <svg class="-ml-1 mr-2 h-5 w-5 text-black opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <!-- Task Card -->
    <div class="max-w-4xl">
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-subtle">
            <!-- Top Section: Title and Priority -->
            <div class="flex items-start justify-between gap-4 mb-6">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-black leading-tight">
                        {{ $task->title }}
                    </h2>
                </div>
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest
                        @if($task->priority === 'urgent') bg-red-50 text-red-700 border border-red-100
                        @elseif($task->priority === 'high') bg-orange-50 text-orange-700 border border-orange-100
                        @elseif($task->priority === 'medium') bg-blue-50 text-blue-700 border border-blue-100
                        @else bg-slate-50 text-black border border-soft
                        @endif">
                        {{ ucfirst($task->priority) }}
                    </span>
                </div>
            </div>

            <!-- Middle Section: Badges -->
            <div class="flex flex-wrap items-center gap-3 mb-8">
                @if($task->project)
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-bold text-black opacity-60 bg-slate-50 border border-soft transition-all">
                        <span class="w-2 h-2 rounded-full" style="background-color: #3FA9A6;"></span>
                        {{ $task->project->name }}
                    </div>
                @endif
                
                <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold text-[#3FA9A6] bg-slate-50 border border-soft">
                    #{{ $task->id }}
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h4 class="text-[10px] font-bold text-black opacity-40 uppercase tracking-[0.2em] mb-3">Description</h4>
                <div class="text-black opacity-80 leading-relaxed prose max-w-none text-sm font-medium">
                    {!! nl2br(e($task->description)) !!}
                </div>
            </div>

            <!-- Divider -->
            <div class="h-px w-full mb-8 bg-slate-100"></div>

            <!-- Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center border border-soft">
                            <svg class="w-5 h-5 text-black opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-black opacity-40 uppercase tracking-wider mb-0.5">Due Date</p>
                            <p class="text-sm font-bold text-black">{{ $task->due_date?->format('F d, Y') ?? 'N/A' }}</p>
                        </div>
                    </div>

                    @if($task->reminder_date)
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center border border-soft">
                            <svg class="w-5 h-5 text-black opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-black opacity-40 uppercase tracking-wider mb-0.5">Reminder Prompt</p>
                            <p class="text-sm font-bold text-black">{{ $task->reminder_date?->format('F d, Y') ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="flex flex-col justify-center">
                    <h4 class="text-[10px] font-bold text-black opacity-40 uppercase tracking-[0.2em] mb-3">Update Status</h4>
                    <form action="{{ route('user.tasks.update-status', $task) }}" method="POST" class="flex items-center gap-3">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" 
                                class="flex-1 rounded-full border-0 py-2 px-4 text-xs font-bold uppercase tracking-widest text-[#3FA9A6] bg-slate-50 shadow-sm ring-1 ring-inset ring-slate-100 focus:ring-2 focus:ring-inset focus:ring-primary-600 transition-all cursor-pointer">
                            <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        <div class="w-10 h-10 rounded-full flex items-center justify-center border
                            @if($task->status === 'completed') bg-green-50 text-green-700 border-green-100
                            @elseif($task->status === 'in_progress') bg-blue-50 text-blue-700 border-blue-100
                            @else bg-slate-50 text-black border-soft
                            @endif">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </form>
                </div>
            </div>
            
            @if($task->notes)
                <div class="pt-8 border-t border-dashed border-slate-200">
                    <h4 class="text-[10px] font-bold text-black opacity-40 uppercase tracking-[0.2em] mb-4">Additional Details</h4>
                    <p class="text-sm text-black opacity-70 leading-relaxed bg-slate-50/50 p-5 rounded-2xl border border-soft italic font-medium">
                        {{ $task->notes }}
                    </p>
                </div>
            @endif

            @if($task->attachment)
                <div class="mt-8 flex items-center justify-between p-5 rounded-2xl bg-primary-50 border border-primary-100">
                    <div class="flex items-center gap-4 text-primary-700">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-[#3FA9A6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.414a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest opacity-60">Attachment</p>
                            <span class="text-sm font-bold">Attached Document</span>
                        </div>
                    </div>
                    <a href="{{ Storage::url($task->attachment) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest text-white bg-[#3FA9A6] hover:opacity-90 transition-all shadow-lg shadow-primary-600/20">
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
