<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TaskFlow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/darkmode.js'])
</head>
<body class="h-full" style="background-color: #0F1117;">
    <div class="flex h-full" x-data="{ sidebarOpen: false }">
        <!-- Mobile Sidebar -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 md:hidden" 
             role="dialog" 
             aria-modal="true"
             x-cloak>
            
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75" @click="sidebarOpen = false"></div>

            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative flex flex-col w-full max-w-xs h-full" 
                 style="background-color: #0A0D12;">
                
                <div class="absolute top-0 right-0 -mr-12 pt-4">
                    <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="sidebarOpen = false">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Reusing Desktop Sidebar Content for Mobile -->
                <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-800">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #3FA9A6;">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-base font-semibold text-white">TaskFlow</h1>
                        <p class="text-xs text-slate-400">Project Management</p>
                    </div>
                </div>

                <nav class="flex-1 px-4 mt-6 space-y-1 overflow-y-auto">
                    {{-- Exactly the same navigation as desktop --}}
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.dashboard')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.users.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Users
                    </a>
                    <a href="{{ route('admin.tasks.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.tasks.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.tasks.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Tasks
                    </a>
                    <a href="{{ route('admin.notes.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.notes.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.notes.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Notes
                    </a>
                    <a href="{{ route('admin.meetings.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.meetings.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.meetings.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Meetings
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.contacts.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.contacts.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Contacts
                    </a>
                    <a href="{{ route('admin.trash.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.trash.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.trash.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Trash
                    </a>

                    <div class="pt-6">
                        <div class="flex items-center justify-between px-3 mb-2">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Projects</span>
                            <a href="{{ route('admin.projects.create') }}" class="text-slate-500 hover:text-primary-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </a>
                        </div>
                        <a href="{{ route('admin.projects.index') }}" class="group flex items-center justify-between gap-3 px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-dark-hover rounded-lg transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                                <span class="text-sm">All Projects</span>
                            </div>
                        </a>
                        @foreach($sidebarProjects as $project)
                            <a href="{{ route('admin.projects.show', $project) }}" class="group flex items-center justify-between gap-3 px-3 py-2 text-sm {{ request()->is('admin/projects/'.$project->id) ? 'text-white bg-dark-hover' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }} rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full {{ request()->is('admin/projects/'.$project->id) ? 'bg-purple-500' : 'bg-purple-500/50 group-hover:bg-purple-500' }} transition-colors"></div>
                                    <span class="text-sm truncate">{{ $project->name }}</span>
                                </div>
                                @if($project->tasks_count > 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-800 text-slate-400 group-hover:text-white transition-colors">
                                        {{ $project->tasks_count }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>

                    <!-- Team Section -->
                    <div class="pt-6">
                        <div class="flex items-center justify-between px-3 mb-2">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Team</span>
                            <a href="{{ route('admin.users.create') }}" class="text-slate-500 hover:text-primary-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </a>
                        </div>
                        @foreach($sidebarUsers as $user)
                            <a href="{{ route('admin.users.show', $user) }}" class="group flex items-center justify-between gap-3 px-3 py-2 text-sm {{ request()->is('admin/users/'.$user->id) ? 'text-white bg-dark-hover' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }} rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <!-- <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold text-white transition-colors" style="background: linear-gradient(to bottom right, #5eeee5, #3fa9a6);">
                                        {{ substr($user->name, 0, 1) }}
                                    </div> -->
                                    <span class="text-sm truncate">{{ $user->name }}</span>
                                </div>
                                @if($user->tasks_count > 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-800 text-slate-400 group-hover:text-white transition-colors">
                                        {{ $user->tasks_count }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>

                </nav>

                <div class="flex-shrink-0 border-t border-slate-800 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(to bottom right, #5eeee5, #3fa9a6);">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-white hover:bg-dark-hover rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow border-r" style="background-color: #0A0D12; border-color: #1A1D24;">
                <!-- Logo -->
                <div class="flex items-center gap-3 px-6 py-5">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #3FA9A6;">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-base font-semibold text-white">TaskFlow</h1>
                        <p class="text-xs text-slate-400">Project Management</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 mt-6 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.dashboard')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.users.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Users
                    </a>
                    <a href="{{ route('admin.tasks.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.tasks.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.tasks.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Tasks
                    </a>
                    <a href="{{ route('admin.notes.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.notes.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.notes.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Notes
                    </a>
                    <a href="{{ route('admin.meetings.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.meetings.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.meetings.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Meetings
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.contacts.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.contacts.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Contact List
                    </a>
                    <a href="{{ route('admin.trash.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.trash.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('admin.trash.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Trash
                    </a>

                    <!-- Projects Section -->
                    <div class="pt-6 pb-4">
                        <div class="flex items-center justify-between px-3 mb-2">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Projects</span>
                            <a href="{{ route('admin.projects.create') }}" class="text-slate-500 hover:text-primary-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.projects.index') }}" class="group flex items-center justify-between gap-3 px-3 py-2 text-sm {{ request()->routeIs('admin.projects.index') ? 'text-white bg-dark-hover' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }} rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.projects.index') ? 'bg-purple-500' : 'bg-purple-500/50 group-hover:bg-purple-500' }} transition-colors"></div>
                                    <span class="text-sm">All Projects</span>
                                </div>
                            </a>
                            
                            @foreach($sidebarProjects as $project)
                                <a href="{{ route('admin.projects.show', $project) }}" class="group flex items-center justify-between gap-3 px-3 py-2 text-sm {{ request()->routeIs('admin.projects.show') && request()->route('project')->id == $project->id ? 'text-white bg-dark-hover' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }} rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.projects.show') && request()->route('project')->id == $project->id ? 'bg-purple-500' : 'bg-purple-500/50 group-hover:bg-purple-500' }} transition-colors"></div>
                                        <span class="text-sm truncate">{{ $project->name }}</span>
                                    </div>
                                    @if($project->tasks_count > 0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-800 text-slate-400 group-hover:text-white transition-colors">
                                            {{ $project->tasks_count }}
                                        </span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Team Section -->
                    <div class="pt-6 pb-4">
                        <div class="flex items-center justify-between px-3 mb-2">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Team</span>
                            <a href="{{ route('admin.users.create') }}" class="text-slate-500 hover:text-primary-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="space-y-1">
                            @foreach($sidebarUsers as $user)
                                <a href="{{ route('admin.users.show', $user) }}" class="group flex items-center justify-between gap-3 px-3 py-2 text-sm {{ request()->routeIs('admin.users.show') && request()->route('user')->id == $user->id ? 'text-white bg-dark-hover' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }} rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <!-- <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold text-white transition-colors" style="background: linear-gradient(to bottom right, #5eeee5, #3fa9a6);">
                                            {{ substr($user->name, 0, 2) }}
                                        </div> -->
                                        <span class="text-sm truncate">{{ $user->name }}</span>
                                    </div>
                                    @if($user->tasks_count > 0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-800 text-slate-400 group-hover:text-white transition-colors">
                                            {{ $user->tasks_count }}
                                        </span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </nav>

                <!-- User Profile -->
                <div class="flex-shrink-0 border-t border-slate-800 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(to bottom right, #5eeee5, #3fa9a6);">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-white hover:bg-dark-hover rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top bar -->
            <div class="relative z-10 flex-shrink-0 flex h-16 border-b" style="background-color: #0F1117; border-color: #1A1D24;">
                <div class="flex-1 px-4 sm:px-6 flex justify-between items-center">
                    <button type="button" @click="sidebarOpen = true" class="p-2 text-slate-400 hover:text-white md:hidden transition-colors">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex-1"></div>
                    <!-- <div class="ml-4 flex items-center gap-3">
                        <button id="darkModeToggle" class="p-2 text-slate-400 hover:text-white hover:bg-dark-hover rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                        </button>
                    </div> -->
                </div>
            </div>

            <!-- Page content -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none" style="background-color: #0F1117;">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        @if(session('success'))
                            <div class="mb-4 rounded-lg bg-primary-500/10 border border-primary-500/20 p-4">
                                <p class="text-sm font-medium text-primary-400">{{ session('success') }}</p>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 rounded-lg bg-red-500/10 border border-red-500/20 p-4">
                                <p class="text-sm font-medium text-red-400">{{ session('error') }}</p>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Global Edit Modal -->
    <div x-data="editModalComponent()"
         @open-edit-modal.window="openModal($event.detail)"
         x-show="open"
         class="fixed inset-0 z-[100] overflow-y-auto"
         x-cloak>
        
        <!-- Backdrop -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" 
             @click="closeModal()"></div>

        <!-- Modal -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl text-left shadow-2xl transition-all my-8 w-[95%] md:w-[90%] lg:w-[85%] max-w-6xl border border-[#2A2D36]"
                 style="background-color: #1A1D24;">
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white" x-text="title">Edit Record</h3>
                        <button @click="closeModal()" class="text-slate-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div x-show="loading" class="flex justify-center py-12">
                        <svg class="animate-spin h-10 w-10 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>

                    <div x-show="!loading" x-html="html" class="edit-form-container"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editModalComponent() {
            return {
                open: false,
                url: '',
                title: 'Edit Record',
                loading: false,
                html: '',
                openModal(detail) {
                    this.open = true;
                    this.url = detail.url;
                    this.title = detail.title || 'Edit Record';
                    this.loading = true;
                    this.html = '';
                    
                    fetch(this.url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text();
                    })
                    .then(data => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(data, 'text/html');
                        let form = doc.querySelector('main form') || doc.querySelector('form');
                        
                        if (form) {
                            this.html = `<div class="p-0">${form.outerHTML}</div>`;
                        } else {
                            this.html = `<div class='text-red-400 p-8 text-center'>
                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <p class="font-bold">Form not found</p>
                                <p class="text-sm mt-2">Could not extract the edit form from the page.</p>
                            </div>`;
                        }
                        this.loading = false;
                    })
                    .catch(error => {
                        this.html = `<div class='text-red-400 p-8 text-center'>
                            <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="font-bold">Error loading form</p>
                            <p class="text-sm mt-2">${error.message}</p>
                        </div>`;
                        this.loading = false;
                    });
                },
                closeModal() {
                    this.open = false;
                }
            }
        }
    </script>

    <!-- Global Delete Confirmation Modal -->
    <div x-data="{ 
            open: false, 
            action: '', 
            title: 'Confirm Deletion',
            message: 'Are you sure you want to delete this record? This action cannot be undone.' 
          }"
         @open-delete-modal.window="open = true; action = $event.detail.action; title = $event.detail.title || 'Confirm Deletion'; message = $event.detail.message || 'Are you sure you want to delete this record? This action cannot be undone.';"
         x-show="open"
         class="fixed inset-0 z-[100] overflow-y-auto"
         x-cloak>
        
        <!-- Backdrop -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" 
             @click="open = false"></div>

        <!-- Modal -->
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-[#2A2D36]"
                 style="background-color: #1A1D24;">
                
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4 text-red-500">
                        <div class="w-12 h-12 rounded-full bg-red-500/10 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white" x-text="title">Delete Record</h3>
                    </div>
                    
                    <p class="text-slate-400 leading-relaxed mb-8" x-text="message">
                        Are you sure you want to delete this record? This action cannot be undone.
                    </p>

                    <div class="flex gap-3">
                        <button type="button" 
                                @click="open = false" 
                                class="flex-1 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-400 hover:text-white hover:bg-slate-800 transition-colors border border-[#2A2D36]">
                            Cancel
                        </button>
                        <form :action="action" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-red-600 hover:bg-red-500 transition-colors shadow-lg shadow-red-600/20">
                                Delete Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        [x-cloak] { display: none !important; }
        .edit-form-container form {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
    </style>
</body>
</html>
