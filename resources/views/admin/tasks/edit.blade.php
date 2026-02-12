@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">Edit Task</h1>
            <p class="mt-1 text-sm text-slate-400">Update task details</p>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.tasks.show', $task) }}" class="inline-flex items-center rounded-md bg-[#1A1D24] px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                View
            </a>
            <a href="{{ route('admin.tasks.index') }}" class="inline-flex items-center rounded-md bg-[#1A1D24] px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                Cancel
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.tasks.update', $task) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="rounded-2xl shadow-xl overflow-hidden" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <div class="px-4 py-5 sm:p-8 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-300">Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required
                           class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm @error('title') ring-red-500 @enderror">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Project -->
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-slate-300">Project</label>
                        <select name="project_id" id="project_id"
                                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                            <option value="">None</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Assigned To -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-slate-300">Assigned To *</label>
                        <select name="user_id" id="user_id" required
                                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $task->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-slate-300">Due Date *</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}" required
                               class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                    </div>

                    <!-- Reminder Date -->
                    <div>
                        <label for="reminder_date" class="block text-sm font-medium text-slate-300">Reminder Date</label>
                        <input type="date" name="reminder_date" id="reminder_date" value="{{ old('reminder_date', $task->reminder_date?->format('Y-m-d')) }}"
                               class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-300">Status *</label>
                        <select name="status" id="status" required
                                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                            <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-slate-300">Priority *</label>
                        <select name="priority" id="priority" required
                                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                            <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ old('priority', $task->priority) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-300">Description *</label>
                    <textarea name="description" id="description" rows="4" required
                              class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">{{ old('description', $task->description) }}</textarea>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-slate-300">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">{{ old('notes', $task->notes) }}</textarea>
                </div>

                <!-- Attachment -->
                <div>
                    <label class="block text-sm font-medium text-slate-300">Attachment</label>
                    @if($task->attachment)
                        <div class="mt-2 text-sm text-slate-400">
                            Current: <a href="{{ Storage::url($task->attachment) }}" target="_blank" class="text-primary-400 hover:text-primary-300">View attachment</a>
                        </div>
                    @endif
                    <input type="file" name="attachment" id="attachment"
                           class="mt-2 block w-full text-sm text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50/10 file:text-primary-400 hover:file:bg-primary-50/20">
                    <p class="mt-1 text-xs text-slate-500">Upload a new file to replace the current one</p>
                </div>
            </div>

            <div class="px-4 py-3 bg-[#1A1D24]/50 text-right sm:px-6 border-t border-[#2A2D36]">
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500" style="background-color: #3FA9A6;">
                    Update Task
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
