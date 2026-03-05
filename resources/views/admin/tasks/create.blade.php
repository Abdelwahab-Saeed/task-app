@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Create Task</h1>
            <p class="mt-1 text-sm text-black opacity-50">Add a new task to the system</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.tasks.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                Cancel
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white shadow rounded-lg border border-slate-100">
            <div class="px-4 py-5 sm:p-6 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-black">Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('title') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Project -->
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-black">Project *</label>
                        <select name="project_id" id="project_id" required
                                class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('project_id') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                            <option value="">None</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assigned To -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-black">Assigned To *</label>
                        <select name="user_id" id="user_id" 
                                class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('user_id') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                            <option value="">Select user...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{  old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-black">Due Date</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" 
                               class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('due_date') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                        @error('due_date')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reminder Date -->
                    <div>
                        <label for="reminder_date" class="block text-sm font-medium text-black">Reminder Date</label>
                        <input type="date" name="reminder_date" id="reminder_date" value="{{ old('reminder_date') }}"
                               class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('reminder_date') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                        @error('reminder_date')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-black">Priority</label>
                        <select name="priority" id="priority" 
                                class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('priority') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                        @error('priority')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-black">Description</label>
                    <textarea name="description" id="description" rows="4" 
                              class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('description') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-black">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">{{ old('notes') }}</textarea>
                </div>

                <!-- Attachment -->
                <div>
                    <label for="attachment" class="block text-sm font-medium text-black">Attachment</label>
                    <input type="file" name="attachment" id="attachment"
                           class="mt-2 block w-full text-sm text-black opacity-40 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-black opacity-70 hover:file:bg-slate-100">
                    @error('attachment')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="px-4 py-3 text-right sm:px-6 bg-slate-50 border-t border-slate-50">
                <button type="submit" class="inline-flex justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600" style="background-color: #3FA9A6;">
                    Create Task
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
