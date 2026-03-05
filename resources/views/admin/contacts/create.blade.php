@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-black">Add New Contact</h1>
        <p class="mt-1 text-sm text-black opacity-50">Create a new business contact</p>
    </div>

    <form action="{{ route('admin.contacts.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white shadow rounded-lg border border-slate-100 p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Company Name -->
                <div class="md:col-span-2">
                    <label for="company_name" class="block text-sm font-medium text-black">Company Name</label>
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('company_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Contact Person -->
                <div>
                    <label for="contact_person" class="block text-sm font-medium text-black">Contact Person</label>
                    <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}"
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('contact_person') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-black">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-black">Contact Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">
                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-black">Notes</label>
                    <textarea name="notes" id="notes" rows="4"
                              class="mt-2 block w-full rounded-md border-slate-100 py-1.5 px-3 text-black shadow-sm focus:ring-2 focus:ring-inset sm:text-sm" style="background-color: #F8FAFC; border: 1px solid #F1F5F9;">{{ old('notes') }}</textarea>
                    @error('notes') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-semibold text-black opacity-70 shadow-sm border border-slate-50 hover:bg-slate-200 transition-colors">Cancel</a>
                <button type="submit" class="rounded-md px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 transition-colors" style="background-color: #3FA9A6;">
                    Save Contact
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
