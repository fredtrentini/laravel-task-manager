<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $projects = Project::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('projects/ProjectManager', [
            'projects' => $projects,
        ]);
    }

    public function store(ProjectRequest $request)
    {
        $user = $request->user();
        $attributes = $request->validated();

        if ($request->hasFile('file')) {
            $file_path = $request->file('file')->store('projects_files', 'public');
            $attributes['file'] = $file_path;
        }

        $user->projects()->create($attributes);

        return redirect()->route('projects.index');
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $attributes = $request->validated();

        if ($request->hasFile('file')) {
            $file_path = $request->file('file')->store('projects_files', 'public');
            $attributes['file'] = $file_path;
        }

        $project->update($attributes);

        return redirect()->route('projects.index');
    }

    public function destroy(ProjectRequest $request, Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }
}
