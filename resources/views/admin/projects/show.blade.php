@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Project Details</h1>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.projects.edit', $project) }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                Edit
            </a>
            <a href="{{ route('admin.projects.index') }}" class="inline-flex items-centers rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                Back
            </a>
        </div>
    </div>

    <!-- Project Card -->
    <div class="max-w-4xl">
        <div class="rounded-2xl shadow-2xl overflow-hidden" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <!-- Header Section -->
            <div class="p-8 border-b" style="border-color: #2A2D36;">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex-1">
                        <h2 class="text-3xl font-extrabold text-white tracking-tight">
                            {{ $project->name }}
                        </h2>
                        <div class="mt-3 flex items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest bg-primary-500/10 text-primary-400 border border-primary-500/20">
                                Project
                            </span>
                            <span class="text-slate-400 text-sm font-medium">
                                Created {{ $project->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-shrink-0 bg-[#1A1D24] border border-[#2A2D36] rounded-xl px-5 py-3 text-center">
                        <div class="text-2xl font-bold text-white">{{ $project->tasks->count() }}</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Total Tasks</div>
                    </div>
                </div>
            </div>

            <!-- Tasks Section -->
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Related Tasks
                    </h3>
                    @if($project->tasks->count() > 0)
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Showing last {{ min(10, $project->tasks->count()) }}</span>
                    @endif
                </div>

                @if($project->tasks->count() > 0)
                    <div class="space-y-3">
                        @foreach($project->tasks->take(10) as $task)
                            <a href="{{ route('admin.tasks.show', $task) }}" class="group flex items-center justify-between p-4 rounded-xl transition-all hover:bg-[#1A1D24] border border-transparent hover:border-[#2A2D36]">
                                <div class="flex items-center gap-4">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $task->status === 'completed' ? 'bg-green-500' : 'bg-blue-500' }}"></div>
                                    <span class="text-slate-200 font-medium group-hover:text-white transition-colors">{{ $task->title }}</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-xs font-bold uppercase tracking-widest {{ $task->status === 'completed' ? 'text-green-500/70' : 'text-slate-500' }}">
                                        {{ str_replace('_', ' ', $task->status) }}
                                    </span>
                                    <svg class="w-4 h-4 text-slate-600 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 rounded-2xl border-2 border-dashed border-[#2A2D36] bg-[#1A1D24]/50">
                        <svg class="w-12 h-12 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-3.586a1 1 0 00-.707.293l-1.414 1.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 009.586 13H4"></path>
                        </svg>
                        <p class="text-slate-500 font-medium">No tasks linked to this project yet.</p>
                    </div>
                @endif
            </div>
            
            <!-- Danger Zone Footer -->
            <div class="px-8 py-5 bg-[#1A1D24]/50 border-t border-[#2A2D36] flex justify-end">
                <button type="button" 
                        @click="$dispatch('open-delete-modal', { 
                            action: '{{ route('admin.projects.destroy', $project) }}',
                            title: 'Delete Project',
                            message: 'Are you sure you want to delete project \'{{ $project->name }}\'?'
                        })"
                        class="text-slate-500 hover:text-red-500 text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Project
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
