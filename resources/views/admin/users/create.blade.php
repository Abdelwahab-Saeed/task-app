@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">Create User</h1>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center rounded-md bg-[#1A1D24] px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-[#2A2D36] hover:bg-[#2A2D36] transition-colors">
                Cancel
            </a>
        </div>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="rounded-2xl shadow-xl overflow-hidden" style="background-color: #22252E; border: 1px solid #2A2D36;">
            <div class="px-4 py-5 sm:p-8 space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm @error('name') ring-red-500 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300">Email *</label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}" 
                           class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm @error('email') ring-red-500 @enderror">
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300">Password *</label>
                    <input type="password" name="password" id="password" 
                           class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm @error('password') ring-red-500 @enderror">
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-300">Confirm Password *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-slate-300">Role *</label>
                    <select name="role" id="role" 
                            class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm @error('role') ring-red-500 @enderror">
                        <option value="user" {{ old('role', 'user') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-300">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                           class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-white bg-[#1A1D24] shadow-sm ring-1 ring-inset ring-[#2A2D36] focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                </div>
                @error('phone')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="px-4 py-3 bg-[#1A1D24]/50 text-right sm:px-6 border-t border-[#2A2D36]">
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition-colors" style="background-color: #3FA9A6;">
                    Create User
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
