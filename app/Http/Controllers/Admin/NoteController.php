<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Note::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        $notes = $query->latest()->get();

        return view('admin.notes.index', compact('notes'));
    }

    public function create()
    {
        return view('admin.notes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'reference_link' => 'nullable|string|max:255',
        ]);

        Note::create($validated);

        return redirect()->route('admin.notes.index')->with('success', 'Note created successfully.');
    }

    public function show(Note $note)
    {
        return view('admin.notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        return view('admin.notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'reference_link' => 'nullable|string|max:255',
        ]);

        $note->update($validated);

        return redirect()->route('admin.notes.index')->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        $note->delete(); // Soft delete

        return redirect()->route('admin.notes.index')->with('success', 'Note moved to trash.');
    }
}
