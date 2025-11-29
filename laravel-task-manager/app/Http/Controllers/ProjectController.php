<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $user = $request->user();

        $attributes = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date|after_or_equal:today',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file_path = $request->file('file')->store('projects_files', 'public');
            $attributes['file'] = $file_path;
        }

        $attributes['user_id'] = $user->id;

        Project::query()->create($attributes);

        return redirect()->route('projects.index');
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $attributes = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date|after_or_equal:today',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file_path = $request->file('file')->store('projects_files', 'public');
            $attributes['file'] = $file_path;
        }

        $project->update($attributes);

        return redirect()->route('projects.index');
    }

    public function destroy(Request $request, Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('projects.index');
    }
}
