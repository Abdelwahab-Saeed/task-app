@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">Tasks</h1>
            <p class="mt-1 text-sm text-slate-400">Manage all tasks in the system</p>
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
    <div class="bg-white shadow rounded-lg" style="background-color: #22252E; border: 1px solid #2A2D36;">
        <form method="GET" action="{{ route('admin.tasks.index') }}" class="p-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..." class="block w-full rounded-md border-0 py-1.5 px-3 text-white shadow-sm ring-1 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #1A1D24; border-color: #2A2D36; color: white;" />
                </div>
                <div>
                    <select name="status" class="block w-full rounded-md border-0 py-1.5 px-3 text-white" style="background-color: #1A1D24; border-color: #2A2D36; shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div>
                    <select name="priority" class="block w-full rounded-md border-0 py-1.5 px-3 text-white" style="background-color: #1A1D24; border-color: #2A2D36; shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
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
                    <a href="{{ route('admin.tasks.index') }}" class="flex-1 text-center rounded-md bg-[#1A1D24] px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tasks Table -->
    <div class="shadow rounded-lg" style="background-color: #22252E; border: 1px solid #2A2D36;">
        <div class="overflow-x-auto">
            <table class="min-w-full" style="border-top: 1px solid #2A2D36;">
                <thead style="background-color: #1A1D24;">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Task</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Assigned To</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Project</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Due Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Priority</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody style="background-color: #22252E;">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-opacity-50" style="border-bottom: 1px solid #2A2D36;" x-data="{ 
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
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Handle success if needed (e.g., toast)
                                    }
                                })
                                .finally(() => {
                                    this.updating = false;
                                });
                            }
                        }">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-white cursor-pointer hover:text-primary-400 transition-colors"
                                     :class="{ 'line-through opacity-50': status === 'completed' }"
                                     @click="$dispatch('open-edit-modal', { 
                                         url: '{{ route('admin.tasks.edit', $task) }}',
                                         title: 'Edit Task: {{ $task->title }}'
                                     })">
                                    {{ $task->title }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-300">{{ $task->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-400">{{ $task->project?->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-300">{{ $task->due_date?->format('M d, Y') ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="relative inline-block w-full">
                                    <select x-model="status" 
                                            @change="updateStatus"
                                            :disabled="updating"
                                            class="block w-full rounded-full border-0 py-1 pl-3 pr-8 text-xs font-semibold leading-5 appearance-none focus:ring-2 focus:ring-inset transition-colors cursor-pointer"
                                            :class="{
                                                'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 focus:ring-green-500': status === 'completed',
                                                'bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 focus:ring-blue-500': status === 'in_progress',
                                                'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-gray-500': status === 'pending',
                                                'opacity-50 cursor-wait': updating
                                            }">
                                        <option value="pending" style="background-color: #1A1D24; color: white;">Pending</option>
                                        <option value="in_progress" style="background-color: #1A1D24; color: white;">In Progress</option>
                                        <option value="completed" style="background-color: #1A1D24; color: white;">Completed</option>
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
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                    @if($task->priority === 'urgent') bg-red-500/10 text-red-400 border border-red-500/20
                                    @elseif($task->priority === 'high') bg-orange-500/10 text-orange-400 border border-orange-500/20
                                    @elseif($task->priority === 'medium') bg-yellow-500/10 text-yellow-400 border border-yellow-500/20
                                    @else bg-gray-500/10 text-gray-400 border border-gray-500/20
                                    @endif">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.tasks.show', $task) }}" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700/50 rounded-lg transition-colors" title="View">
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
                                            style="background-color: #3FA9A6;" class="p-2 text-primary-400 hover:text-primary-300 hover:bg-primary-400/10 rounded-lg transition-colors" title="Edit">
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
                                            class="p-2 text-red-400 hover:text-red-300 hover:bg-red-400/10 rounded-lg transition-colors" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No tasks found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- Pagination -->
        @if($tasks->hasPages())
            <div class="px-6 py-4 border-t border-[#2A2D36]">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
