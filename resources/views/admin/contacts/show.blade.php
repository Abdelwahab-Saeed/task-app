@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">Contact Details</h1>
            <p class="mt-1 text-sm text-slate-400">View information for {{ $contact->company_name }}</p>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.contacts.edit', $contact) }}" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                Edit Contact
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-white/20 hover:bg-white/20">
                Back to List
            </a>
        </div>
    </div>

    <!-- Contact Info Card -->
    <div class="max-w-3xl">
        <div class="rounded-2xl p-8 shadow-2xl transition-all" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <div class="flex items-start justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-white leading-tight mb-2">
                        {{ $contact->company_name }}
                    </h2>
                    <div class="flex items-center gap-2 text-slate-400">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-sm font-medium">{{ $contact->contact_person ?? 'No contact person specified' }}</span>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="h-px w-full mb-8" style="background-color: #2A2D36;"></div>

            <!-- Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Phone -->
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Phone Number</p>
                    <div class="flex items-center gap-2 text-white">
                        <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-lg font-medium">{{ $contact->phone }}</span>
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Email Address</p>
                    <div class="flex items-center gap-2 text-white">
                        <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-lg font-medium">{{ $contact->email ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            @if($contact->notes)
                <div class="pt-8 border-t border-dashed border-slate-700/50">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Notes</h4>
                    <p class="text-sm text-slate-400 leading-relaxed italic">
                        "{{ $contact->notes }}"
                    </p>
                </div>
            @endif
        </div>

        <!-- Delete Action -->
        <div class="mt-8 flex justify-end">
            <button type="button" 
                    @click="$dispatch('open-delete-modal', { 
                        action: '{{ route('admin.contacts.destroy', $contact) }}',
                        title: 'Delete Contact',
                        message: 'Are you sure you want to delete contact \'{{ $contact->company_name }}\'?'
                    })"
                    class="text-slate-500 hover:text-red-500 text-sm font-medium transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Delete Contact
            </button>
        </div>
    </div>
</div>
@endsection
