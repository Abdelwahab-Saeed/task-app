@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Meeting Details</h1>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.meetings.edit', $meeting) }}" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm transition-colors" style="background-color: #3FA9A6;">
                Edit
            </a>
            <a href="{{ route('admin.meetings.index') }}" class="inline-flex items-center rounded-md bg-[#1A1D24] px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                Back
            </a>
        </div>
    </div>

    <!-- Meeting Card -->
    <div class="max-w-4xl">
        <div class="rounded-2xl shadow-2xl overflow-hidden" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <!-- Header Section -->
            <div class="p-8 border-b" style="border-color: #2A2D36;">
                <div class="flex items-start justify-between gap-6 mb-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-amber-500/10 text-amber-500 border border-amber-500/20">
                                Meeting
                            </span>
                            <span class="text-slate-500 text-sm font-medium">
                                Scheduled for {{ $meeting->scheduled_at->format('M d, Y') }}
                            </span>
                        </div>
                        <h2 class="text-3xl font-extrabold text-white tracking-tight leading-tight">
                            {{ $meeting->title }}
                        </h2>
                    </div>
                    <div class="flex-shrink-0 bg-primary-500/10 border border-primary-500/20 rounded-2xl px-6 py-4 text-center">
                        <div class="text-sm font-bold text-slate-200 uppercase tracking-widest mb-1">{{ $meeting->scheduled_at->format('h:i A') }}</div>
                        <div class="text-[10px] font-bold text-slate-200 uppercase tracking-widest">{{ $meeting->scheduled_at->format('T') }}</div>
                    </div>
                </div>

            </div>

            <!-- Agenda Section -->
            <div class="p-8 bg-[#1A1D24]/30 border-b border-[#2A2D36]">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Meeting Agenda
                </h3>
                <div class="text-slate-300 leading-relaxed prose prose-invert max-w-none">
                    {!! nl2br(e($meeting->agenda)) !!}
                </div>
            </div>

            <!-- Notes Section -->
            <div class="p-8">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Internal Notes
                </h3>
                @if($meeting->notes)
                    <div class="text-slate-400 leading-relaxed prose prose-invert max-w-none">
                        {!! nl2br(e($meeting->notes)) !!}
                    </div>
                @else
                    <p class="text-slate-600 italic">No internal notes captured for this meeting.</p>
                @endif
            </div>

            <!-- Footer Footer (Danger Zone) -->
            <div class="px-8 py-5 bg-[#1A1D24]/50 border-t border-[#2A2D36] flex items-center justify-between">
                <span class="text-slate-600 text-xs font-medium">Created {{ $meeting->created_at->diffForHumans() }}</span>
                <button type="button" 
                        @click="$dispatch('open-delete-modal', { 
                            action: '{{ route('admin.meetings.destroy', $meeting) }}',
                            title: 'Delete Meeting',
                            message: 'Are you sure you want to delete meeting \'{{ $meeting->title }}\'?'
                        })"
                        class="text-slate-500 hover:text-red-500 text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Meeting
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
