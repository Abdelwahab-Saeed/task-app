<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard - TaskFlow</title>
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

                <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-800">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #3FA9A6;">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-base font-semibold text-white">TaskFlow</h1>
                        <p class="text-xs text-slate-400">User Dashboard</p>
                    </div>
                </div>

                <nav class="flex-1 px-4 mt-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('user.dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('user.dashboard') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('user.dashboard')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('user.tasks.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('user.tasks.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('user.tasks.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        My Tasks
                    </a>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-base font-semibold text-white">TaskFlow</h1>
                        <p class="text-xs text-slate-400">User Dashboard</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 mt-6 space-y-1">
                    <a href="{{ route('user.dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('user.dashboard') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('user.dashboard')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('user.tasks.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('user.tasks.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-dark-hover' }}" @if(request()->routeIs('user.tasks.*')) style="background-color: #3FA9A6;" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        My Tasks
                    </a>
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
    </style>
</body>
</html>
