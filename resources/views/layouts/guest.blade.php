<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50 dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Task Management') }} - Login</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/darkmode.js'])
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900/20 p-4">
                    <p class="text-sm text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 rounded-md bg-red-50 dark:bg-red-900/20 p-4">
                    <p class="text-sm text-red-800 dark:text-red-200">{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </div>

       <!-- Copyright Footer -->
        <div class="border-t px-6 py-3 text-center" style="border-color: #1A1D24;">
            <p class="text-s text-slate-500"> 
                Developed and Maintained by <a href="https://falak-innovation.com" target="_blank" class="text-primary-500 hover:text-primary-400">Falak Innovation</a> 
                © All Rights Reserved - Task Management.
            </p>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>

</body>
</html>
