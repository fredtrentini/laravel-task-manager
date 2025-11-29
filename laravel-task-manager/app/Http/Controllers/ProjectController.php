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

        return Inertia::render('Projects', [
            'projects' => $projects,
        ]);
    }
}
