@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Edit Project</h1>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2">
            <a href="{{ route('admin.projects.show', $project) }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                View
            </a>
            <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                Cancel
            </a>
        </div>
    </div>

    <form action="{{ route('admin.projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-white shadow rounded-lg border border-slate-100 overflow-hidden">
            <div class="px-4 py-5 sm:p-8">
                <div>
                    <label for="name" class="block text-sm font-medium text-black">Project Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" required
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm @error('name') ring-red-500 @enderror" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="px-4 py-3 bg-slate-50 text-right sm:px-6 border-t border-slate-50">
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500" style="background-color: #3FA9A6;">
                    Update Project
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
