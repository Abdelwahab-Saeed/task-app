@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">User Details</h1>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                Edit
            </a>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                Back
            </a>
        </div>
    </div>

    <!-- User Card -->
    <div class="max-w-3xl">
        <div class="rounded-2xl p-8 shadow-2xl transition-all hover:shadow-primary-500/5" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <!-- Top Section: Name and Role -->
            <div class="flex items-start justify-between gap-4 mb-6">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-white leading-tight">
                        {{ $user->name }}
                    </h2>
                    <p class="mt-2 text-slate-400 font-medium">
                        {{ $user->email }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider
                        {{ $user->role === 'admin' ? 'bg-purple-500/10 text-purple-400 border border-purple-500/20' : 'bg-blue-500/10 text-blue-400 border border-blue-500/20' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <!-- Middle Section: Contact Info -->
            <div class="flex flex-wrap items-center gap-4 mb-8">
                @if($user->phone)
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium" style="background-color: #1A1D24; border: 1px solid #2A2D36; color: #94A3B8;">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ $user->phone }}
                    </div>
                @endif
                
                <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium" style="background-color: #1A1D24; border: 1px solid #2A2D36; color: #94A3B8;">
                    ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                </div>
            </div>

            <!-- Divider -->
            <div class="h-px w-full mb-8" style="background-color: #2A2D36;"></div>

            <!-- Bottom Section: Info -->
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <!-- Join Date -->
                    <div class="flex items-center gap-2 text-slate-400">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium italic">Member since {{ $user->created_at->format('M Y') }}</span>
                    </div>

                    <!-- Last Update -->
                    <div class="flex items-center gap-2 text-slate-400">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span class="text-sm font-medium">Updated {{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($user->id !== auth()->id())
            <!-- Danger Zone (Delete) -->
            <div class="mt-8 flex justify-end">
                <button type="button" 
                        @click="$dispatch('open-delete-modal', { 
                            action: '{{ route('admin.users.destroy', $user) }}',
                            title: 'Delete User',
                            message: 'Are you sure you want to delete user \'{{ $user->name }}\'?'
                        })"
                        class="text-slate-500 hover:text-red-500 text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete User
                </button>
            </div>
        @endif
    </div>
</div>
@endsection
