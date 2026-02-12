@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">Create Note</h1>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.notes.index') }}" class="inline-flex items-center rounded-md bg-[#1A1D24] px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                Cancel
            </a>
        </div>
    </div>

    <form action="{{ route('admin.notes.store') }}" method="POST">
        @csrf
        
        <div class="rounded-2xl shadow-xl overflow-hidden" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <div class="px-4 py-5 sm:p-8 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-300">Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                           class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm @error('title') ring-red-500 @enderror">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-slate-300">Content *</label>
                    <textarea name="content" id="content" rows="10" 
                              class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm @error('content') ring-red-500 @enderror">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reference_link" class="block text-sm font-medium text-slate-300">Reference Link</label>
                    <input type="text" name="reference_link" id="reference_link" value="{{ old('reference_link') }}"
                           class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                    <p class="mt-1 text-xs text-slate-500">Optional URL reference for this note</p>
                    @error('reference_link')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="px-4 py-3 bg-[#1A1D24]/50 text-right sm:px-6 border-t border-[#2A2D36]">
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition-colors" style="background-color: #3FA9A6;">
                    Create Note
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
