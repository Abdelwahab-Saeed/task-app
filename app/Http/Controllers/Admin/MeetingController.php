<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $query = Meeting::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('company_name', 'like', '%' . $request->search . '%');
        }

        $meetings = $query->orderBy('scheduled_at', 'desc')->paginate(5);

        return view('admin.meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('admin.meetings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'agenda' => 'required|string',
            'scheduled_at' => 'required|date|after:now',
            'contact_person' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Meeting::create($validated);

        return redirect()->route('admin.meetings.index')->with('success', 'Meeting created successfully.');
    }

    public function show(Meeting $meeting)
    {
        return view('admin.meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        return view('admin.meetings.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'agenda' => 'required|string',
            'scheduled_at' => 'required|date|after:now',
            'contact_person' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $meeting->update($validated);

        return redirect()->route('admin.meetings.index')->with('success', 'Meeting updated successfully.');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete(); // Soft delete

        return redirect()->route('admin.meetings.index')->with('success', 'Meeting moved to trash.');
    }
}
