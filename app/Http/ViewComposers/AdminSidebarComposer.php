<?php

namespace App\Http\ViewComposers;

use App\Models\Project;
use App\Models\User;
use Illuminate\View\View;

class AdminSidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sidebarProjects', Project::withCount('tasks')->get());
        $view->with('sidebarUsers', User::where('role', 'user')->withCount('tasks')->get());
    }
}

