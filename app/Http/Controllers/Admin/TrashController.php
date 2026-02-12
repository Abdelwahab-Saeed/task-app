<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Note;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TrashController extends Controller
{
    public function index(Request $request)
    {
        $trashedItems = collect();
        $filter = $request->get('filter', 'all');
        $search = $request->get('search', '');
        $perPage = 5;
        $page = $request->get('page', 1);

        if ($filter === 'all' || $filter === 'task') {
            $tasks = Task::onlyTrashed()
                ->when($search, fn($query) => $query->where('title', 'like', "%{$search}%"))
                ->get()
                ->map(function ($item) {
                    $item->type = 'Task';
                    $item->type_color = 'blue';
                    return $item;
                });
            $trashedItems = $trashedItems->concat($tasks);
        }

        if ($filter === 'all' || $filter === 'note') {
            $notes = Note::onlyTrashed()
                ->when($search, fn($query) => $query->where('title', 'like', "%{$search}%"))
                ->get()
                ->map(function ($item) {
                    $item->type = 'Note';
                    $item->type_color = 'green';
                    return $item;
                });
            $trashedItems = $trashedItems->concat($notes);
        }

        if ($filter === 'all' || $filter === 'meeting') {
            $meetings = Meeting::onlyTrashed()
                ->when($search, fn($query) => $query->where('title', 'like', "%{$search}%"))
                ->get()
                ->map(function ($item) {
                    $item->type = 'Meeting';
                    $item->type_color = 'purple';
                    return $item;
                });
            $trashedItems = $trashedItems->concat($meetings);
        }

        $trashedItems = $trashedItems->sortByDesc('deleted_at');

        // Manual Pagination
        $paginatedItems = new LengthAwarePaginator(
            $trashedItems->forPage($page, $perPage),
            $trashedItems->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.trash.index', [
            'trashedItems' => $paginatedItems,
            'filter' => $filter,
            'search' => $search
        ]);
    }

    public function restore(Request $request, $type, $id)
    {
        $model = match(strtolower($type)) {
            'task' => Task::onlyTrashed()->find($id),
            'note' => Note::onlyTrashed()->find($id),
            'meeting' => Meeting::onlyTrashed()->find($id),
            default => null,
        };

        if ($model) {
            $model->restore();
            return back()->with('success', ucfirst($type) . ' restored successfully.');
        }

        return back()->with('error', 'Item not found.');
    }

    public function destroy($type, $id)
    {
        $model = match(strtolower($type)) {
            'task' => Task::onlyTrashed()->find($id),
            'note' => Note::onlyTrashed()->find($id),
            'meeting' => Meeting::onlyTrashed()->find($id),
            default => null,
        };

        if ($model) {
            $model->forceDelete();
            return back()->with('success', ucfirst($type) . ' deleted permanently.');
        }

        return back()->with('error', 'Item not found.');
    }

    public function empty()
    {
        Task::onlyTrashed()->forceDelete();
        Note::onlyTrashed()->forceDelete();
        Meeting::onlyTrashed()->forceDelete();

        return back()->with('success', 'Trash emptied successfully.');
    }
}
