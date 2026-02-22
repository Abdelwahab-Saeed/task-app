@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">Contacts</h1>
            <p class="mt-1 text-sm text-slate-400">Manage your business contacts</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.contacts.create') }}" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                New Contact
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg" style="background-color: #22252E; border: 1px solid #2A2D36;">
        <form method="GET" action="{{ route('admin.contacts.index') }}" class="p-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search contacts..." class="block w-full rounded-md border-0 py-1.5 px-3 text-white shadow-sm ring-1 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #1A1D24; border-color: #2A2D36; color: white;" />
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                        Filter
                    </button>
                    <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center text-center rounded-md bg-[#1A1D24] px-4 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="shadow rounded-lg" style="background-color: #22252E; border: 1px solid #2A2D36;">
        <div class="overflow-x-auto">
            <table class="min-w-full" style="border-top: 1px solid #2A2D36;">
                <thead style="background-color: #1A1D24;">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Company</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Contact Person</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Phone</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody style="background-color: #22252E;">
                    @forelse($contacts as $contact)
                        <tr class="hover:bg-opacity-50" style="border-bottom: 1px solid #2A2D36;">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-white cursor-pointer hover:text-primary-400 transition-colors"
                                     @click="$dispatch('open-edit-modal', { 
                                         url: '{{ route('admin.contacts.edit', $contact) }}',
                                         title: 'Edit Contact: {{ $contact->company_name }}'
                                     })">
                                    {{ $contact->company_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-300">{{ $contact->contact_person ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-400">{{ $contact->phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-300">{{ $contact->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700/50 rounded-lg transition-colors" title="View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <button type="button" 
                                            @click="$dispatch('open-edit-modal', { 
                                                url: '{{ route('admin.contacts.edit', $contact) }}',
                                                title: 'Edit Contact: {{ $contact->company_name }}'
                                            })"
                                            class="p-2 text-primary-400 hover:text-primary-300 hover:bg-primary-400/10 rounded-lg transition-colors" style="background-color: #3FA9A6;" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" 
                                            @click="$dispatch('open-delete-modal', { 
                                                action: '{{ route('admin.contacts.destroy', $contact) }}',
                                                title: 'Delete Contact',
                                                message: 'Are you sure you want to delete contact \'{{ $contact->company_name }}\'?'
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
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No contacts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($contacts->hasPages())
            <div class="px-6 py-4 border-t border-[#2A2D36]">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
