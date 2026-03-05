@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Create Meeting</h1>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.meetings.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                Cancel
            </a>
        </div>
    </div>

    <form action="{{ route('admin.meetings.store') }}" method="POST">
        @csrf
        
        <div class="bg-white shadow rounded-lg border border-slate-100 overflow-hidden">
            <div class="px-4 py-5 sm:p-8 space-y-6">
                
                <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-black">Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('title') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                            @error('title')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="scheduled_at" class="block text-sm font-medium text-black">Scheduled Date & Time *</label>
                            <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at') }}"
                                   class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('scheduled_at') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                            @error('scheduled_at')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                </div>

                <div>
                    <label for="agenda" class="block text-sm font-medium text-black">Agenda *</label>
                    <textarea name="agenda" id="agenda" rows="4"
                              class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('agenda') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">{{ old('agenda') }}</textarea>
                    @error('agenda')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-black">Notes</label>
                    <textarea name="notes" id="notes" rows="4"
                              class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="px-4 py-3 bg-slate-50 text-right sm:px-6 border-t border-slate-50">
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500" style="background-color: #3FA9A6;">
                    Create Meeting
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
