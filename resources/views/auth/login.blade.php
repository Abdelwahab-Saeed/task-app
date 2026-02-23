@extends('layouts.guest')

@section('content')


    <div class="w-full max-w-md bg-white dark:bg-gray-900 shadow-2xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700">

        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                Welcome Back
            </h2>
        </div>

        <form method="POST" action="/login" class="space-y-8">
            @csrf

            {{-- Email Floating --}}
            <div class="relative">
                <input
                    type="text"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder=""
                    class="peer w-full px-4 pt-5 pb-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('email') border-red-500 @enderror"
                />
                <label
                    class="absolute left-4 top-2 text-gray-500 dark:text-gray-400 text-sm transition-all 
                    peer-placeholder-shown:top-4 
                    peer-placeholder-shown:text-base 
                    peer-placeholder-shown:text-gray-400
                    peer-focus:top-2 
                    peer-focus:text-sm 
                    peer-focus:text-primary-500">
                    Email Address
                </label>

                @error('email')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Floating + Show/Hide --}}
            <div x-data="{ show: false }" class="relative">
                <input
                    :type="show ? 'text' : 'password'"
                    name="password"
                    value="{{ old('password') }}"
                    placeholder=" "
                    class="peer w-full px-4 pt-5 pb-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('password') border-red-500 @enderror"
                />

                <label
                    class="absolute left-4 top-2 text-gray-500 dark:text-gray-400 text-sm transition-all 
                    peer-placeholder-shown:top-4 
                    peer-placeholder-shown:text-base 
                    peer-placeholder-shown:text-gray-400
                    peer-focus:top-2 
                    peer-focus:text-sm 
                    peer-focus:text-primary-500">
                    Password
                </label>

                {{-- Eye Icon --}}
                <button
                    type="button"
                    @click="show = !show"
                    class="absolute right-4 top-4 text-gray-400 hover:text-primary-500 transition"
                >
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 
                            8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7
                            -4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>

                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19
                            c-4.478 0-8.269-2.943-9.542-7
                            a9.956 9.956 0 012.042-3.368M6.223 6.223A9.956 
                            9.956 0 0112 5c4.478 0 8.269 2.943 
                            9.542 7a9.956 9.956 0 01-4.293 5.077M15 
                            12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m3-3v3m0 0l3 3m-3-3l-3 3"/>
                    </svg>
                </button>

                @error('password')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember --}}
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <span class="text-gray-600 dark:text-gray-400">Remember me</span>
                </label>

                
            </div>

            {{-- Submit --}}
            <button 
                type="submit"
                class="w-full cursor-pointer bg-white hover:bg-primary-700 text-stroke-200 font-semibold py-3 rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5"
            >
                Sign In
            </button>

        </form>
        
    </div>


@endsection
