@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">Edit Project</h1>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.projects.show', $project) }}" class="inline-flex items-center rounded-md bg-[#1A1D24] px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                View
            </a>
            <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center rounded-md bg-[#1A1D24] px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                Cancel
            </a>
        </div>
    </div>

    <form action="{{ route('admin.projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="rounded-2xl shadow-xl overflow-hidden" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <div class="px-4 py-5 sm:p-8">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300">Project Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" required
                           class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm @error('name') ring-red-500 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="px-4 py-3 bg-[#1A1D24]/50 text-right sm:px-6 border-t border-[#2A2D36]">
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500" style="background-color: #3FA9A6;">
                    Update Project
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
