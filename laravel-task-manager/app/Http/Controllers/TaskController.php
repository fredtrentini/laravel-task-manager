<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskFormRequest;
use App\Models\Project;
use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request, Project $project)
    {
        $user = $request->user();

        $tasks = Task::where('project_id', $project->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('tasks/TaskManager', [
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }

    public function store(TaskFormRequest $request, Project $project)
    {
        $user = $request->user();
        $attributes = $request->validated();

        if ($request->hasFile('file')) {
            $file_path = $request->file('file')->store('tasks_files', 'public');
            $attributes['file'] = $file_path;
        }

        $project->tasks()->create([
            ...$attributes,
            'status' => 1,
        ]);

        return redirect()->route('tasks.index', [ 'project' => $project->id ]);
    }

    public function update(TaskFormRequest $request, Project $project, Task $task)
    {
        $attributes = $request->validated();

        if ($request->hasFile('file')) {
            $file_path = $request->file('file')->store('tasks_files', 'public');
            $attributes['file'] = $file_path;
        }

        $task->update($attributes);

        return redirect()->route('tasks.index', [ 'project' => $project->id ]);
    }

    public function destroy(TaskFormRequest $request, Project $project, Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index', [ 'project' => $project->id ]);
    }
}
