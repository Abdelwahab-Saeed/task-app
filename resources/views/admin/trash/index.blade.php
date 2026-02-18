@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">Trash</h1>
            <p class="mt-1 text-sm text-slate-400">Manage deleted items</p>
        </div>
        <div class="mt-4 sm:mt-0">
            @if($trashedItems->count() > 0)
                <button type="button" 
                        @click="$dispatch('open-delete-modal', { 
                            action: '{{ route('admin.trash.empty') }}',
                            title: 'Empty Trash',
                            message: 'Are you sure you want to permanently delete all items in trash? This action cannot be undone.'
                        })"
                        class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    Empty Trash
                </button>
            @endif
        </div>
    </div>

    <!-- Filters -->
    <div class="shadow rounded-lg" style="background-color: #22252E; border: 1px solid #2A2D36;">
        <form method="GET" action="{{ route('admin.trash.index') }}" class="p-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search in trash..." class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 dark:text-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                </div>
                <div>
                    <select name="filter" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 dark:text-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                        <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Types</option>
                        <option value="task" {{ $filter == 'task' ? 'selected' : '' }}>Tasks</option>
                        <option value="note" {{ $filter == 'note' ? 'selected' : '' }}>Notes</option>
                        <option value="meeting" {{ $filter == 'meeting' ? 'selected' : '' }}>Meetings</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                        Filter
                    </button>
                    <a href="{{ route('admin.trash.index') }}" class="flex-1 text-center rounded-md bg-[#1A1D24] px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Trash Table -->
    <div class="shadow rounded-lg" style="background-color: #22252E; border: 1px solid #2A2D36;">
        <div class="overflow-x-auto">
            <table class="min-w-full" style="border-top: 1px solid #2A2D36;">
                <thead style="background-color: #1A1D24;">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Item</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Deleted At</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody style="background-color: #22252E;">
                    @forelse($trashedItems as $item)
                        <tr class="hover:bg-opacity-50" style="border-bottom: 1px solid #2A2D36;">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-white">{{ $item->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                    @if($item->type_color === 'blue') bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200
                                    @elseif($item->type_color === 'green') bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200
                                    @elseif($item->type_color === 'purple') bg-purple-100 dark:bg-purple-900/20 text-purple-800 dark:text-purple-200
                                    @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                    @endif">
                                    {{ $item->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-300">{{ $item->deleted_at->diffForHumans() }}</div>
                                <div class="text-xs text-slate-500">{{ $item->deleted_at->format('M d, Y g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('admin.trash.restore', ['type' => strtolower($item->type), 'id' => $item->id]) }}" method="POST" class="inline mr-3">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                        Restore
                                    </button>
                                </form>
                                <button type="button" 
                                        @click="$dispatch('open-delete-modal', { 
                                            action: '{{ route('admin.trash.destroy', ['type' => strtolower($item->type), 'id' => $item->id]) }}',
                                            title: 'Delete Forever',
                                            message: 'Are you sure you want to permanently delete this {{ strtolower($item->type) }} (\'{{ $item->title }}\')? This action cannot be undone.'
                                        })"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    Delete Forever
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                                <h3 class="mt-2 text-sm font-semibold text-white">No items in trash</h3>
                                <p class="mt-1 text-sm text-slate-500">Trash is empty</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($trashedItems->hasPages())
            <div class="px-6 py-4 border-t border-[#2A2D36]">
                {{ $trashedItems->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
