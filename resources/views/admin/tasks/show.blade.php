@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-black">{{ $task->title }}</h1>
            <p class="mt-1 text-sm text-black opacity-60">Task details and progress</p>
        </div>
        <div class="mt-4 flex items-center gap-3 sm:mt-0">
            <a href="{{ route('admin.tasks.index') }}" class="rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-subtle hover:bg-slate-200 transition-colors">
                Back to Tasks
            </a>
            <button type="button" 
                    @click="$dispatch('open-edit-modal', { 
                        url: '{{ route('admin.tasks.edit', $task) }}',
                        title: 'Edit Task: {{ $task->title }}'
                    })"
                    class="inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                Edit Task
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-subtle shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-subtle bg-slate-50/50">
                    <h3 class="text-lg font-bold text-black">Task Details</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <h4 class="text-sm font-bold text-black opacity-40 uppercase tracking-wider mb-2">Description</h4>
                        <div class="text-black leading-relaxed whitespace-pre-wrap">
                            {{ $task->description ?: 'No description provided.' }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 pt-6 border-t border-soft">
                        <div>
                            <h4 class="text-sm font-bold text-black opacity-40 uppercase tracking-wider mb-2">Project</h4>
                            <div class="text-black font-medium">{{ $task->project?->name ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-black opacity-40 uppercase tracking-wider mb-2">Due Date</h4>
                            <div class="text-black font-medium">{{ $task->due_date?->format('M d, Y') ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="bg-white rounded-xl border border-subtle shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-subtle bg-slate-50/50">
                    <h3 class="text-lg font-bold text-black">Internal Notes</h3>
                </div>
                <div class="p-6">
                    <div class="text-black leading-relaxed">
                        {{ $task->notes ?: 'No internal notes.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-subtle shadow-sm p-6">
                <h3 class="text-lg font-bold text-black mb-6">Status & Priority</h3>
                
                <div class="space-y-6">
                    <div x-data="{ 
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
                        <label class="text-xs font-bold text-black opacity-40 uppercase tracking-wider mb-2 block">Task Status</label>
                        <select x-model="status" @change="updateStatus" :disabled="updating"
                                class="mt-1 block w-full rounded-lg border-subtle bg-soft py-2 px-3 text-sm font-bold text-black focus:ring-2 focus:ring-primary-600 transition-all">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-black opacity-40 uppercase tracking-wider mb-2 block">Priority Level</label>
                        <div class="mt-1">
                            <span class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider
                                @if($task->priority === 'high') bg-red-50 text-red-700 border border-red-100
                                @elseif($task->priority === 'medium') bg-yellow-50 text-yellow-700 border border-yellow-100
                                @else bg-blue-50 text-blue-700 border border-blue-100
                                @endif">
                                {{ $task->priority === 'high' ? 'Urgent' : ucfirst($task->priority) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if($task->attachment)
                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ Storage::url($task->attachment) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-medium text-black opacity-40 hover:opacity-100 transition-colors">
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
                    class="text-black opacity-40 hover:text-red-600 text-sm font-medium transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Delete Task
            </button>
        </div>
    </div>
</div>
@endsection
