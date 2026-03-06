@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-black">User Details</h1>
            <p class="mt-1 text-sm text-black opacity-60">User profile and assigned tasks</p>
        </div>
        <div class="mt-4 flex items-center gap-3 sm:mt-0">
            <a href="{{ route('admin.users.index') }}" class="rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-subtle hover:bg-slate-200 transition-colors">
                Back to Users
            </a>
            <button type="button" 
                    @click="$dispatch('open-edit-modal', { 
                        url: '{{ route('admin.users.edit', $user) }}',
                        title: 'Edit User: {{ $user->name }}'
                    })"
                    class="inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                Edit User
            </button>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- User Info Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl border border-subtle shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-subtle bg-slate-50/50">
                    <h3 class="text-lg font-bold text-black">User Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-col items-center mb-6">
                        <div class="h-24 w-24 rounded-full flex items-center justify-center text-white font-bold text-3xl mb-4 shadow-lg shadow-primary-500/20" style="background: linear-gradient(to bottom right, #5eeee5, #3fa9a6);">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <h2 class="text-xl font-bold text-black">{{ $user->name }}</h2>
                        <div class="mt-2">
                            <span class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider
                                {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4 pt-6 border-t border-soft">
                        <div>
                            <label class="text-sm font-bold text-black uppercase tracking-wider">Email Address</label>
                            <p class="text-md text-black font-medium mt-1">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-bold text-black uppercase tracking-wider">Phone Number</label>
                            <p class="text-md text-black font-medium mt-1">{{ $user->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-bold text-black uppercase tracking-wider">Join Date</label>
                            <p class="text-md text-black font-medium mt-1">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="bg-white rounded-xl border border-subtle shadow-sm p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-slate-50 rounded-xl border border-soft">
                        <p class="text-xs font-bold text-black uppercase tracking-wider">Tasks</p>
                        <p class="text-2xl font-bold text-black mt-1">{{ $user->tasks->count() }}</p>
                    </div>
                    <div class="text-center p-4 bg-slate-50 rounded-xl border border-soft">
                        <p class="text-xs font-bold text-black uppercase tracking-wider">Completed</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $user->tasks->where('status', 'completed')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assigned Tasks Section -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow rounded-lg border border-subtle overflow-hidden">
                <div class="px-6 py-4 border-b border-subtle bg-slate-50/50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-black flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Assigned Tasks
                    </h3>
                    <span class="text-xs font-bold text-black uppercase tracking-widest">TOTAL TASKS: {{ $user->tasks->count() }}</span>
                </div>

                <div class="p-6">
                    @if($user->tasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($user->tasks as $task)
                                <div class="border border-indigo-50 rounded-lg">
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
                                    <div class="text-sm text-black p-4">
                                        {{ $task->description }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 rounded-2xl border-2 border-dashed border-soft bg-slate-50">
                            <p class="text-black font-medium italic">No tasks assigned to this user yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($user->id !== auth()->id())
                <div class="flex justify-end pt-4">
                    <button type="button" 
                            @click="$dispatch('open-delete-modal', { 
                                action: '{{ route('admin.users.destroy', $user) }}',
                                title: 'Delete User',
                                message: 'Are you sure you want to delete user \'{{ $user->name }}\'?'
                            })"
                            class="text-black hover:text-red-600 text-sm font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete User
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
