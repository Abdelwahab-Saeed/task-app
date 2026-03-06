@extends('layouts.user')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">My Tasks</h1>
            <p class="mt-1 text-sm text-black opacity-60">View and track your assigned tasks</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-xl border border-subtle">
        <form method="GET" action="{{ route('user.tasks.index') }}" class="p-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..." class="block w-full rounded-md border-gray-200 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-primary-600 sm:text-sm" />
                </div>
                <div>
                    <select name="status" class="block w-full rounded-md border-gray-200 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-primary-600 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div>
                    <select name="priority" class="block w-full rounded-md border-gray-200 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-primary-600 sm:text-sm">
                        <option value="">All Priorities</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90 transition-all" style="background-color: #3FA9A6;">
                        Filter
                    </button>
                    <a href="{{ route('user.tasks.index') }}" class="flex-1 text-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black shadow-sm border border-subtle hover:bg-slate-200 transition-all">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tasks Table -->
    <div class="bg-white shadow rounded-xl border border-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-subtle">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Task Info</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Project</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Due Date</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Priority</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-black uppercase tracking-wider">Dashboard</th>
                        <th scope="col" class="relative px-6 py-4 text-right pr-12 text-xs font-bold text-black uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-subtle">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-slate-50/50 transition-all" x-data="{ 
                            status: '{{ $task->status }}',
                            isAdded: {{ $task->is_added ? 'true' : 'false' }},
                            updating: false,
                            updatingDashboard: false,
                            async updateStatus() {
                                this.updating = true;
                                try {
                                    const response = await fetch('{{ route('user.tasks.update-status', $task) }}', {
                                        method: 'PATCH',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify({ status: this.status })
                                    });
                                    const data = await response.json();
                                    if (!response.ok) throw new Error(data.message || 'Update failed');
                                } catch (error) {
                                    alert(error.message);
                                    this.status = '{{ $task->status }}';
                                } finally {
                                    this.updating = false;
                                }
                            },
                            toggleDashboard() {
                                this.updatingDashboard = true;
                                fetch('{{ route('user.tasks.toggle-added', $task) }}', {
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
                                <div class="text-sm font-medium text-black transition-all duration-200"
                                     :class="{ 'line-through opacity-50': status === 'completed' }">
                                    {{ $task->title }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black opacity-60 font-medium">{{ $task->project?->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black opacity-60">{{ $task->due_date?->format('M d, Y') ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="relative inline-block w-32 text-xs">
                                    <select x-model="status" 
                                            @change="updateStatus"
                                            :disabled="updating"
                                            class="block w-full rounded-full border-0 py-1 pl-3 pr-8 font-bold uppercase tracking-widest appearance-none focus:ring-2 focus:ring-inset transition-colors cursor-pointer"
                                            :class="{
                                                'bg-green-50 text-green-700 focus:ring-green-500 border border-green-100': status === 'completed',
                                                'bg-blue-50 text-blue-700 focus:ring-blue-500 border border-blue-100': status === 'in_progress',
                                                'bg-slate-50 text-black focus:ring-slate-500 border border-soft': status === 'pending',
                                                'opacity-50 cursor-wait': updating
                                            }">
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                    
                                    <!-- Dropdown Arrow Icon -->
                                    <div class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" x-show="!updating">
                                        <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>

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
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-widest
                                    @if($task->priority === 'urgent') bg-red-50 text-red-700 border border-red-100
                                    @elseif($task->priority === 'high') bg-orange-50 text-orange-700 border border-orange-100
                                    @elseif($task->priority === 'medium') bg-blue-50 text-blue-700 border border-blue-100
                                    @else bg-slate-50 text-black border border-soft
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
                                <a href="{{ route('user.tasks.show', $task) }}" class="p-2 text-slate-400 hover:text-[#3FA9A6] hover:bg-slate-100 rounded-lg transition-all inline-flex items-center gap-2" title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span class="font-bold">Details</span>
                                </a>
                            </td>
                        </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center bg-white">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <p class="text-sm text-black opacity-60 font-medium italic">No tasks assigned to you yet.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>
</div>
@endsection
