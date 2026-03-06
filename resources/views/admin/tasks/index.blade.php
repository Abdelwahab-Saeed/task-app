@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Tasks</h1>
            <p class="mt-1 text-sm text-black opacity-60">Manage all tasks in the system</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.tasks.create') }}" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                New Task
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg border border-slate-100">
        <form method="GET" action="{{ route('admin.tasks.index') }}" class="p-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..." class="block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;" />
                </div>
                <div>
                    <select name="status" class="block w-full rounded-md border-slate-100 py-1.5 px-3 text-black focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div>
                    <select name="priority" class="block w-full rounded-md border-slate-100 py-1.5 px-3 text-black focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
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
                    <a href="{{ route('admin.tasks.index') }}" class="flex-1 text-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tasks Table -->
    <div class="bg-white shadow rounded-lg border border-subtle">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-black uppercase tracking-wider">Task</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-black uppercase tracking-wider">Assigned To</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-black uppercase tracking-wider">Project</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-black uppercase tracking-wider">Due Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-black uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-black uppercase tracking-wider">Priority</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-black uppercase tracking-wider">Dashboard</th>
                        <th scope="col" class="relative px-6 py-3"><span class="">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-subtle">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-slate-50 transition-colors"
                            x-data="{ 
                                status: '{{ $task->status }}',
                                isAdded: {{ $task->is_added ? 'true' : 'false' }},
                                updating: false,
                                updatingDashboard: false,
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
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // Handle success if needed (e.g., toast)
                                        }
                                    })
                                    .finally(() => {
                                        this.updating = false;
                                    });
                                },
                                toggleDashboard() {
                                    this.updatingDashboard = true;
                                    fetch('{{ route('admin.tasks.toggle-added', $task) }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            this.isAdded = data.is_added;
                                        }
                                    })
                                    .finally(() => {
                                        this.updatingDashboard = false;
                                    });
                                }
                            }">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-md font-medium text-black cursor-pointer hover:text-primary-600 transition-colors"
                                     :class="{ 'line-through': status === 'completed' }"
                                     @click="$dispatch('open-edit-modal', { 
                                         url: '{{ route('admin.tasks.edit', $task) }}',
                                         title: 'Edit Task: {{ $task->title }}'
                                     })">
                                    {{ $task->title }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-md text-black">{{ $task->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-md text-black">{{ $task->project?->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-md text-black">{{ $task->due_date?->format('M d, Y') ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="relative inline-block w-full">
                                    <select x-model="status" 
                                            @change="updateStatus"
                                            :disabled="updating"
                                            class="block w-full rounded-full border-0 py-1 pl-3 pr-8 text-sm font-semibold leading-5 appearance-none focus:ring-2 focus:ring-inset transition-colors cursor-pointer"
                                            :class="{
                                                'bg-green-50 text-green-700 focus:ring-green-500': status === 'completed',
                                                'bg-blue-50 text-blue-700 focus:ring-blue-500': status === 'in_progress',
                                                'bg-slate-50 text-slate-700 focus:ring-slate-500': status === 'pending',
                                                'opacity-50 cursor-wait': updating
                                            }">
                                        <option value="pending" class="bg-white text-black">Pending</option>
                                        <option value="in_progress" class="bg-white text-black">In Progress</option>
                                        <option value="completed" class="bg-white text-black">Completed</option>
                                    </select>
                                    
                                    <template x-if="updating">
                                        <div class="absolute right-2 top-1/2 -translate-y-1/2">
                                            <svg class="animate-spin h-3 w-3 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                    </template>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex rounded-full px-2 text-sm font-semibold leading-5
                                    @if($task->priority === 'urgent') bg-red-50 text-red-700 border border-red-100
                                    @elseif($task->priority === 'high') bg-orange-50 text-orange-700 border border-orange-100
                                    @elseif($task->priority === 'medium') bg-blue-50 text-blue-700 border border-blue-100
                                    @else bg-slate-50 text-slate-600 border border-soft
                                    @endif">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button @click="toggleDashboard" 
                                        :class="isAdded ? 'text-[#3FA9A6]' : 'text-slate-200'"
                                        class="transition-all hover:scale-105" 
                                        :title="isAdded ? 'Remove from Dashboard' : 'Add to Dashboard'"
                                        :disabled="updatingDashboard">
                                    <template x-if="!updatingDashboard">
                                        <svg class="w-10 h-6" viewBox="0 0 40 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="40" height="24" rx="12" fill="currentColor"/>
                                            <circle :cx="isAdded ? 28 : 12" cy="12" r="8" fill="white" class="transition-all duration-200"/>
                                        </svg>
                                    </template>
                                    <template x-if="updatingDashboard">
                                        <div class="w-10 h-6 flex items-center justify-center">
                                            <svg class="animate-spin h-4 w-4 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                    </template>
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.tasks.show', $task) }}" class="p-2 text-black opacity-30 hover:opacity-100 hover:bg-slate-100 rounded-lg transition-all" title="View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <button type="button" 
                                            @click="$dispatch('open-edit-modal', { 
                                                url: '{{ route('admin.tasks.edit', $task) }}',
                                                title: 'Edit Task: {{ $task->title }}'
                                            })"
                                            class="p-2 text-primary-600 bg-primary-50 hover:bg-primary-100 rounded-lg transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" 
                                            @click="$dispatch('open-delete-modal', { 
                                                action: '{{ route('admin.tasks.destroy', $task) }}',
                                                title: 'Delete Task',
                                                message: 'Are you sure you want to delete task \'{{ $task->title }}\'?'
                                            })"
                                            class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-all" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-black opacity-40">No tasks found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
