<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()
            ->active()
            ->orderBy('position')
            ->orderByDesc('id')
            ->paginate(12);

        return view('projects.index', compact('projects'));
    }

    public function show(string $slug): View
    {
        $project = Project::query()->active()->where('slug', $slug)->firstOrFail();
        $relatedProjects = Project::query()
            ->active()
            ->where('id', '!=', $project->getKey())
            ->orderBy('position')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}