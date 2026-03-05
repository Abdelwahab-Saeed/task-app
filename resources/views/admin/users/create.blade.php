@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-black">Create User</h1>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">
                Cancel
            </a>
        </div>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white shadow rounded-lg border border-slate-100 overflow-hidden">
            <div class="px-4 py-5 sm:p-8 space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-black">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-black">Email *</label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}" 
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-black">Password *</label>
                    <input type="password" name="password" id="password" 
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-black">Confirm Password *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-black">Role *</label>
                    <select name="role" id="role" 
                            class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                        <option value="user" {{ old('role', 'user') == 'user' ? 'selected' : '' }} style="background-color: white; color: #000;">User</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }} style="background-color: white; color: #000;">Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-black">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                </div>
                @error('phone')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="px-4 py-3 bg-slate-50 text-right sm:px-6 border-t border-slate-50">
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition-colors" style="background-color: #3FA9A6;">
                    Create User
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
