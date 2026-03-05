@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Edit Task</h1>
            <p class="mt-1 text-sm text-black opacity-50">Update task details</p>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.tasks.show', $task) }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                View
            </a>
            <a href="{{ route('admin.tasks.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                Cancel
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.tasks.update', $task) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white shadow rounded-lg border border-slate-100 overflow-hidden">
            <div class="px-4 py-5 sm:p-8 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-black">Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Project -->
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-black">Project *</label>
                        <select name="project_id" id="project_id" required
                                class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                            <option value="" style="background-color: white; color: #000;">None</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }} style="background-color: white; color: #000;">
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Assigned To -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-black">Assigned To *</label>
                        <select name="user_id" id="user_id" required
                                class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $task->user_id) == $user->id ? 'selected' : '' }} style="background-color: white; color: #000;">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-black">Due Date</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                               class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    </div>

                    <!-- Reminder Date -->
                    <div>
                        <label for="reminder_date" class="block text-sm font-medium text-black">Reminder Date</label>
                        <input type="date" name="reminder_date" id="reminder_date" value="{{ old('reminder_date', $task->reminder_date?->format('Y-m-d')) }}"
                               class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    </div>


                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-black">Priority</label>
                        <select name="priority" id="priority"
                                class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                            <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }} style="background-color: white; color: #000;">Low</option>
                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }} style="background-color: white; color: #000;">Medium</option>
                            <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }} style="background-color: white; color: #000;">High</option>
                            <option value="urgent" {{ old('priority', $task->priority) == 'urgent' ? 'selected' : '' }} style="background-color: white; color: #000;">Urgent</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-black">Status</label>
                        <select name="status" id="status"
                                class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                            <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }} style="background-color: white; color: #000;">Pending</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }} style="background-color: white; color: #000;">In Progress</option>
                            <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }} style="background-color: white; color: #000;">Completed</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-black">Description</label>
                    <textarea name="description" id="description" rows="4" 
                              class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">{{ old('description', $task->description) }}</textarea>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-black">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">{{ old('notes', $task->notes) }}</textarea>
                </div>

                <!-- Attachment -->
                <div>
                    <label class="block text-sm font-medium text-black">Attachment</label>
                    @if($task->attachment)
                        <div class="mt-2 text-sm text-black opacity-40">
                            Current: <a href="{{ Storage::url($task->attachment) }}" target="_blank" class="text-primary-600 hover:opacity-100">View attachment</a>
                        </div>
                    @endif
                    <input type="file" name="attachment" id="attachment"
                           class="mt-2 block w-full text-sm text-black opacity-30 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                    <p class="mt-1 text-xs text-black opacity-40">Upload a new file to replace the current one</p>
                </div>
            </div>

            <div class="px-4 py-3 bg-slate-50 text-right sm:px-6 border-t border-slate-50">
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500" style="background-color: #3FA9A6;">
                    Update Task
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
