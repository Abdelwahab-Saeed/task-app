@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-0">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white">Edit Meeting</h1>
        <p class="mt-1 text-sm text-slate-400">Update meeting details and agenda</p>
    </div>

    <form action="{{ route('admin.meetings.update', $meeting) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="rounded-xl p-8" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title Section -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-slate-300">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $meeting->title) }}"
                           class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm @error('title') ring-red-500 @enderror">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Section -->
                <div class="md:col-span-2">
                    <label for="scheduled_at" class="block text-sm font-medium text-slate-300">Scheduled Date & Time</label>
                    <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at', $meeting->scheduled_at ? $meeting->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                           class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm @error('scheduled_at') ring-red-500 @enderror">
                    @error('scheduled_at')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Agenda Section -->
                <div class="md:col-span-2">
                    <label for="agenda" class="block text-sm font-medium text-slate-300">Agenda</label>
                    <textarea name="agenda" id="agenda" rows="6"
                              class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm @error('agenda') ring-red-500 @enderror">{{ old('agenda', $meeting->agenda) }}</textarea>
                    @error('agenda')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes Section -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-slate-300">Notes</label>
                    <textarea name="notes" id="notes" rows="6"
                              class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">{{ old('notes', $meeting->notes) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('admin.meetings.index') }}" class="text-sm font-semibold leading-6 text-white hover:text-slate-300 transition-colors">Cancel</a>
                <button type="submit" class="rounded-md px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-colors" style="background-color: #3FA9A6;">
                    Update Meeting Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
