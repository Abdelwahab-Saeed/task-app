@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">Notes</h1>
            <p class="mt-1 text-sm text-slate-400">Manage all notes</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.notes.create') }}" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                New Note
            </a>
        </div>
    </div>

    <div class="shadow rounded-lg" style="background-color: #22252E; border: 1px solid #2A2D36;">
        <div class="overflow-x-auto">
            <table class="min-w-full" style="border-top: 1px solid #2A2D36;">
                <thead style="background-color: #1A1D24;">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Content</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Reference</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Created</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody style="background-color: #22252E;">
                    @forelse($notes as $note)
                        <tr class="hover:bg-opacity-50" style="border-bottom: 1px solid #2A2D36;">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-white cursor-pointer hover:text-primary-400 transition-colors"
                                     @click="$dispatch('open-edit-modal', { 
                                         url: '{{ route('admin.notes.edit', $note) }}',
                                         title: 'Edit Note: {{ $note->title }}'
                                     })">
                                    {{ $note->title }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-400 truncate max-w-xs">{{ Str::limit($note->content, 60) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($note->reference_link)
                                    <a href="{{ $note->reference_link }}" target="_blank" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 text-sm">View</a>
                                @else
                                    <span class="text-sm text-slate-500">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-300">{{ $note->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.notes.show', $note) }}" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700/50 rounded-lg transition-colors" title="View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <button type="button" 
                                            @click="$dispatch('open-edit-modal', { 
                                                url: '{{ route('admin.notes.edit', $note) }}',
                                                title: 'Edit Note: {{ $note->title }}'
                                            })"
                                            style="background-color: #3FA9A6;" class="p-2 text-primary-400 hover:text-primary-300 hover:bg-primary-400/10 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" 
                                            @click="$dispatch('open-delete-modal', { 
                                                action: '{{ route('admin.notes.destroy', $note) }}',
                                                title: 'Delete Note',
                                                message: 'Are you sure you want to delete note \'{{ $note->title }}\'?'
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
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No notes found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        @if($notes->hasPages())
            <div class="px-6 py-4 border-t border-[#2A2D36]">
                {{ $notes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
