@extends('layouts.user')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold text-black">My Dashboard</h1>
        <p class="mt-1 text-sm text-black opacity-60">Welcome back, {{ auth()->user()->name }}. Here's your overview for today</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Active Tasks Card -->
        <div class="relative overflow-hidden rounded-xl p-6 bg-white border border-subtle shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-black opacity-60">Active Tasks</p>
                    <p class="mt-2 text-3xl font-bold text-black">{{ $myActiveTasks }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="p-3 bg-purple-500/10 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Card -->
        <div class="relative overflow-hidden rounded-xl p-6 bg-white border border-subtle shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-black opacity-60">Completed</p>
                    <p class="mt-2 text-3xl font-bold text-black">{{ $myCompletedTasks }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="p-3 bg-green-500/10 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Urgent Tasks Card -->
        <div class="relative overflow-hidden rounded-xl p-6 bg-white border border-subtle shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-black opacity-60">Urgent Tasks</p>
                    <p class="mt-2 text-3xl font-bold text-black">{{ $myUrgentTasks }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="p-3 bg-red-500/10 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!--  Completion Rate Card -->
        <div class="relative overflow-hidden rounded-xl p-6 bg-white border border-subtle shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-black opacity-60">Completion Rate</p>
                    <p class="mt-2 text-3xl font-bold text-black">{{ $completionRate }}%</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="p-3 bg-primary-500/10 rounded-lg">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- Dashboard Tasks -->
        <div class="mt-2 bg-white rounded-xl border border-subtle shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-subtle bg-slate-50/50 flex items-center justify-between">
                <h2 class="text-lg font-bold text-black">Dashboard Tasks</h2>
                <a href="{{ route('user.tasks.index') }}" class="text-sm font-medium text-[#3FA9A6] hover:underline">Manage All</a>
            </div>
            <div class="divide-y divide-subtle">
                @forelse($recentTasks as $task)
                    <div class="p-6 hover:bg-slate-50/50 transition-colors"
                         x-show="isAdded"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         x-data="{ 
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
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-md font-medium text-black transition-all duration-200"
                                        :class="{ 'line-through opacity-50': status === 'completed' }">
                                        {{ $task->title }}
                                    </h3>
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider
                                        @if($task->priority === 'urgent') bg-red-50 text-red-700 border border-red-100
                                        @elseif($task->priority === 'high') bg-orange-50 text-orange-700 border border-orange-100
                                        @elseif($task->priority === 'medium') bg-blue-50 text-blue-700 border border-blue-100
                                        @else bg-slate-50 text-slate-600 border border-soft
                                        @endif">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 text-xs text-black opacity-60">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $task->due_date?->format('M d') ?? 'No date' }}
                                    </span>
                                    @if($task->project)
                                        <span class="flex items-center gap-1">
                                            <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                                            {{ $task->project->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
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
                                    
                                    <template x-if="updating">
                                        <div class="absolute right-2 top-1/2 -translate-y-1/2">
                                            <svg class="animate-spin h-3 w-3 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                    </template>
                                </div>

                                <button @click="toggleDashboard" 
                                        class="transition-all hover:scale-105" 
                                        :class="isAdded ? 'text-[#3FA9A6]' : 'text-slate-200'"
                                        title="Remove from Dashboard"
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
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center bg-white">
                        <p class="text-sm text-black opacity-60 italic">No tasks added to dashboard.</p>
                        <a href="{{ route('user.tasks.index') }}" class="mt-2 inline-block text-xs text-[#3FA9A6] hover:underline">Add tasks from your task list</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
