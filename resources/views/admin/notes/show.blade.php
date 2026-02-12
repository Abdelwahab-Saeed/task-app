@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Note Details</h1>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.notes.edit', $note) }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                Edit
            </a>
            <a href="{{ route('admin.notes.index') }}" class="inline-flex items-center rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                Back
            </a>
        </div>
    </div>

    <!-- Note Card -->
    <div class="max-w-3xl">
        <div class="rounded-2xl p-8 shadow-2xl transition-all hover:shadow-primary-500/5 flex flex-col h-full" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <!-- Header -->
            <div class="flex items-start justify-between gap-4 mb-6">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-white leading-tight">
                        {{ $note->title }}
                    </h2>
                    <div class="mt-2 flex items-center gap-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-primary-500/10 text-primary-400 border border-primary-500/20">
                            Note
                        </span>
                        <span class="text-slate-500 text-xs font-medium">
                            {{ $note->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
                @if($note->reference_link)
                    <a href="{{ $note->reference_link }}" target="_blank" class="p-2 text-primary-400 hover:text-primary-300 hover:bg-primary-500/10 rounded-xl transition-all" title="Open Link">
                        <svg class="w-6 h-6 border-2 border-transparent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                @endif
            </div>

            <!-- Content Area -->
            <div class="flex-1">
                <div class="prose prose-invert prose-slate max-w-none text-slate-300 leading-relaxed whitespace-pre-wrap">
                    {{ $note->content }}
                </div>
            </div>

            <!-- Divider -->
            <div class="mt-8 pt-6 border-t border-[#2A2D36] flex items-center justify-between">
                <div class="flex items-center gap-2 text-slate-500 text-xs font-medium tracking-wide">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Last updated {{ $note->updated_at->diffForHumans() }}
                </div>
                
                <button type="button" 
                        @click="$dispatch('open-delete-modal', { 
                            action: '{{ route('admin.notes.destroy', $note) }}',
                            title: 'Delete Note',
                            message: 'Are you sure you want to delete note \'{{ $note->title }}\'?'
                        })"
                        class="text-slate-600 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
