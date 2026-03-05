@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Projects</h1>
            <p class="mt-1 text-sm text-black opacity-60">Manage all projects</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                New Project
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg border border-slate-100">
        <form method="GET" action="{{ route('admin.projects.index') }}" class="p-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search projects..." class="block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;" />
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm" style="background-color: #3FA9A6;">
                        Filter
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center text-center rounded-md bg-slate-100 px-4 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($projects as $project)
            <div class="bg-white rounded-xl border border-subtle shadow-sm hover:shadow-md transition-all group overflow-hidden flex flex-col">
                <div class="p-6 flex-1">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 bg-primary-500/10 rounded-xl group-hover:bg-primary-500/20 transition-colors">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.projects.show', $project) }}" class="p-2 text-black hover:opacity-100 hover:bg-slate-100 rounded-lg transition-all" title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <button type="button" 
                                    @click="$dispatch('open-edit-modal', { 
                                        url: '{{ route('admin.projects.edit', $project) }}',
                                        title: 'Edit Project: {{ $project->name }}'
                                    })"
                                    class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition-all" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-black group-hover:text-primary-600 transition-colors mb-2">
                        {{ $project->name }}
                    </h3>
                    
                    <div class="flex flex-col gap-3 mt-6 pt-6 border-t border-soft">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-black uppercase tracking-wider">Total Tasks</span>
                            <span class="text-sm font-bold text-black">{{ $project->tasks_count }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-black uppercase tracking-wider">Created</span>
                            <span class="text-sm font-bold text-black">{{ $project->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-slate-50 border-t border-soft flex justify-between items-center group-hover:bg-slate-100 transition-colors">
                    <a href="{{ route('admin.projects.show', $project) }}" class="text-xs font-bold text-primary-600 uppercase tracking-widest flex items-center gap-2">
                        View Project
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    
                    <button type="button" 
                            @click="$dispatch('open-delete-modal', { 
                                action: '{{ route('admin.projects.destroy', $project) }}',
                                title: 'Delete Project',
                                message: 'Are you sure you want to delete project \'{{ $project->name }}\'? This will also delete all tasks in this project.'
                            })"
                            class="text-xs font-bold text-black opacity-20 hover:text-red-600 uppercase tracking-widest transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl border border-dashed border-soft p-12 text-center">
                <p class="text-black opacity-40 font-medium italic">No projects found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
