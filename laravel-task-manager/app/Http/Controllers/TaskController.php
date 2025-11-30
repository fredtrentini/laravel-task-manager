<?php

namespace App\Http\Controllers;

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
}
