@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Project Details</h1>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.projects.edit', $project) }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                Edit
            </a>
            <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                Back
            </a>
        </div>
    </div>

    <!-- Project Card -->
    <div class="max-w-4xl">
        <div class="bg-white shadow rounded-lg border border-subtle overflow-hidden">
            <!-- Header Section -->
            <div class="p-8 border-b border-soft">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex-1">
                        <h2 class="text-3xl font-extrabold text-black tracking-tight">
                            {{ $project->name }}
                        </h2>
                        <div class="mt-3 flex items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest bg-primary-50 text-primary-600 border border-primary-100">
                                Project
                            </span>
                            <span class="text-black text-sm font-bold">
                                Created {{ $project->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-shrink-0 bg-slate-50 border border-subtle rounded-xl px-5 py-3 text-center">
                        <div class="text-2xl font-bold text-black">{{ $project->tasks->count() }}</div>
                        <div class="text-[10px] font-bold text-black uppercase tracking-widest">Total Tasks</div>
                    </div>
                </div>
            </div>

            <!-- Tasks Section -->
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-black flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Related Tasks
                    </h3>
                </div>

                @if($project->tasks->count() > 0)
                    <div class="space-y-3">
                        @foreach($project->tasks as $task)
                            <div class="group flex items-center justify-between p-4 rounded-xl transition-all hover:bg-slate-50 border border-transparent hover:border-soft"
                                 x-data="{ 
                                    status: '{{ $task->status }}',
                                    updating: false,
                                    updateStatus() {
                                        this.updating = true;
                                        fetch('{{ route('admin.tasks.update-status', $task) }}', {
                                            method: 'PATCH',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({ status: this.status })
                                        })
                                        .finally(() => this.updating = false);
                                    }
                                }">
                                <div class="text-md font-medium text-black cursor-pointer hover:text-primary-600 transition-colors"
                                     :class="{ 'line-through': status === 'completed' }"
                                     @click="$dispatch('open-edit-modal', { 
                                         url: '{{ route('admin.tasks.edit', $task) }}',
                                         title: 'Edit Task: {{ $task->title }}'
                                     })">
                                    {{ $task->title }}
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="relative inline-block">
                                        <select x-model="status" 
                                                @change="updateStatus"
                                                :disabled="updating"
                                                class="block w-full rounded-full border-0 py-0.5 pl-3 pr-8 text-[10px] font-bold uppercase tracking-widest appearance-none focus:ring-1 focus:ring-inset transition-colors cursor-pointer"
                                                :class="{
                                                    'bg-green-50 text-green-700 border border-green-100 focus:ring-green-500': status === 'completed',
                                                    'bg-blue-50 text-blue-700 border border-blue-100 focus:ring-blue-500': status === 'in_progress',
                                                    'bg-slate-50 text-black border border-subtle focus:ring-slate-500': status === 'pending',
                                                    'opacity-50 cursor-wait': updating
                                                }">
                                            <option value="pending">Pending</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                    <a href="{{ route('admin.tasks.show', $task) }}" class="group-hover:text-primary-600 transition-colors">
                                        <svg class="w-4 h-4 text-black hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 rounded-2xl border-2 border-dashed border-soft bg-slate-50">
                        <p class="text-black font-medium italic">No tasks linked to this project yet.</p>
                    </div>
                @endif
            </div>
            
            <!-- Danger Zone Footer -->
            <div class="px-8 py-5 bg-slate-50 border-t border-soft flex justify-end">
                <button type="button" 
                        @click="$dispatch('open-delete-modal', { 
                            action: '{{ route('admin.projects.destroy', $project) }}',
                            title: 'Delete Project',
                            message: 'Are you sure you want to delete project \'{{ $project->name }}\'?'
                        })"
                        class="text-black hover:text-red-600 text-sm font-medium transition-colors flex items-center gap-2">
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
