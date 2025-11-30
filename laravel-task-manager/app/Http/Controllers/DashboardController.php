<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        $tasks = Task::query()
        ->whereHas('project', function ($project_query) use ($user_id) {
            $project_query->where('user_id', $user_id);
        })
        ->get();

        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
        ]);
    }
}
