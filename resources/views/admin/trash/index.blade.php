@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Trash</h1>
            <p class="mt-1 text-sm text-black opacity-60">Manage deleted items</p>
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
    <div class="bg-white shadow rounded-lg border border-slate-100">
        <form method="GET" action="{{ route('admin.trash.index') }}" class="p-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search in trash..." class="mt-2 block w-full rounded-md border-subtle py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                </div>
                <div>
                    <select name="filter" class="mt-2 block w-full rounded-md border-subtle py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
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
                    <a href="{{ route('admin.trash.index') }}" class="flex-1 text-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Trash Table -->
    <div class="bg-white shadow rounded-lg border border-subtle">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black opacity-50 uppercase tracking-wider">Item</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black opacity-50 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black opacity-50 uppercase tracking-wider">Deleted At</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-subtle">
                    @forelse($trashedItems as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-black">{{ $item->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                    @if($item->type_color === 'blue') bg-blue-50 text-blue-700 border border-blue-100
                                    @elseif($item->type_color === 'green') bg-green-50 text-green-700 border border-green-100
                                    @elseif($item->type_color === 'purple') bg-purple-50 text-purple-700 border border-purple-100
                                    @else bg-slate-100 text-slate-700
                                    @endif">
                                    {{ $item->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black opacity-70">{{ $item->deleted_at->diffForHumans() }}</div>
                                <div class="text-xs text-black opacity-40">{{ $item->deleted_at->format('M d, Y g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('admin.trash.restore', ['type' => strtolower($item->type), 'id' => $item->id]) }}" method="POST" class="inline mr-3">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900">
                                        Restore
                                    </button>
                                </form>
                                <button type="button" 
                                        @click="$dispatch('open-delete-modal', { 
                                            action: '{{ route('admin.trash.destroy', ['type' => strtolower($item->type), 'id' => $item->id]) }}',
                                            title: 'Delete Forever',
                                            message: 'Are you sure you want to permanently delete this {{ strtolower($item->type) }} (\'{{ $item->title }}\')? This action cannot be undone.'
                                        })"
                                        class="text-red-600 hover:text-red-900">
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
                                <h3 class="mt-2 text-sm font-semibold text-black">No items in trash</h3>
                                <p class="mt-1 text-sm text-black opacity-50">Trash is empty</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($trashedItems->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $trashedItems->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
