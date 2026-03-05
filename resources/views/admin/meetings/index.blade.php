@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Meetings</h1>
            <p class="mt-1 text-sm text-black opacity-60">Manage all meetings</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.meetings.create') }}" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                New Meeting
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg border border-subtle">
        <form method="GET" action="{{ route('admin.meetings.index') }}" class="p-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search meetings..." class="block w-full rounded-md border-subtle py-1.5 px-3 text-black placeholder:text-black placeholder:opacity-40 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm" style="background-color: #F8FAFC; border: 1px solid var(--color-subtle);" />
                </div>
                <div class="flex gap-2 sm:col-span-2">
                    <button type="submit" class="flex-1 rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                        Filter
                    </button>
                    <a href="{{ route('admin.meetings.index') }}" class="flex-1 text-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-soft hover:bg-slate-200 transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Meetings Table -->
    <div class="bg-white shadow rounded-lg border border-subtle">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50">
                    <tr class="border-b border-soft">
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-black  uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-black  uppercase tracking-wider">Date & Time</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-black  uppercase tracking-wider">Agenda</th>
                        <th scope="col" class="relative px-6 py-3"><span class="">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-subtle">
                    @forelse($meetings as $meeting)
                        <tr class="hover:bg-slate-50 transition-colors border-b border-subtle">
                            <td class="px-6 py-4">
                                <div class="text-md font-medium text-black cursor-pointer hover:text-primary-600 transition-colors"
                                     @click="$dispatch('open-edit-modal', { 
                                         url: '{{ route('admin.meetings.edit', $meeting) }}',
                                         title: 'Edit Meeting: {{ $meeting->title }}'
                                     })">
                                    {{ $meeting->title }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-md text-black opacity-70">{{ $meeting->scheduled_at->format('M d, Y g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-md text-black">{{ $meeting->agenda }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-md font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.meetings.show', $meeting) }}" class="p-2 text-black opacity-30 hover:opacity-100 hover:bg-slate-100 rounded-lg transition-all" title="View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <button type="button" 
                                            @click="$dispatch('open-edit-modal', { 
                                                url: '{{ route('admin.meetings.edit', $meeting) }}',
                                                title: 'Edit Meeting: {{ $meeting->title }}'
                                            })"
                                            class="p-2 text-primary-600 bg-primary-50 hover:bg-primary-100 rounded-lg transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" 
                                            @click="$dispatch('open-delete-modal', { 
                                                action: '{{ route('admin.meetings.destroy', $meeting) }}',
                                                title: 'Delete Meeting',
                                                message: 'Are you sure you want to delete meeting \'{{ $meeting->title }}\'?'
                                            })"
                                            class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-all" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-md text-black opacity-40">No meetings found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
