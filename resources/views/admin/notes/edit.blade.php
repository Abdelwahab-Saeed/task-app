@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Edit Note</h1>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.notes.show', $note) }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                View
            </a>
            <a href="{{ route('admin.notes.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                Cancel
            </a>
        </div>
    </div>

    <form action="{{ route('admin.notes.update', $note) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-white shadow rounded-lg border border-slate-100 overflow-hidden">
            <div class="px-4 py-5 sm:p-8 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-black">Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $note->title) }}" required
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('title') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-black">Content *</label>
                    <textarea name="content" id="content" rows="10" required
                              class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('content') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">{{ old('content', $note->content) }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reference_link" class="block text-sm font-medium text-black">Reference Link</label>
                    <input type="text" name="reference_link" id="reference_link" value="{{ old('reference_link', $note->reference_link) }}"
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                </div>
            </div>

            <div class="px-4 py-3 bg-slate-50 text-right sm:px-6 border-t border-slate-50">
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition-colors" style="background-color: #3FA9A6;">
                    Update Note
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
