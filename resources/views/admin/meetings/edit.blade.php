@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-0">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-black">Edit Meeting</h1>
        <p class="mt-1 text-sm text-black opacity-60">Update meeting details and agenda</p>
    </div>

    <form action="{{ route('admin.meetings.update', $meeting) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white shadow rounded-lg border border-slate-100 p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title Section -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-black">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $meeting->title) }}"
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('title') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Section -->
                <div class="md:col-span-2">
                    <label for="scheduled_at" class="block text-sm font-medium text-black">Scheduled Date & Time</label>
                    <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at', $meeting->scheduled_at ? $meeting->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('scheduled_at') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('scheduled_at')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Agenda Section -->
                <div class="md:col-span-2">
                    <label for="agenda" class="block text-sm font-medium text-black">Agenda</label>
                    <textarea name="agenda" id="agenda" rows="6"
                              class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('agenda') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">{{ old('agenda', $meeting->agenda) }}</textarea>
                    @error('agenda')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes Section -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-black">Notes</label>
                    <textarea name="notes" id="notes" rows="6"
                              class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">{{ old('notes', $meeting->notes) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('admin.meetings.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">Cancel</a>
                <button type="submit" class="rounded-md px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-colors" style="background-color: #3FA9A6;">
                    Update Meeting Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
