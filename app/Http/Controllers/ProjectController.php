<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();
    
        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        // Filter by created_at date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
    
        $projects = $query->get();
    
        return response()->json($projects);
    }

    public function show($id)
    {
        return Project::with('tasks')->find($id);
    }

    public function store(Request $request)
    {
        return Project::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return $project;
    }

    public function destroy($id)
    {
        Project::destroy($id);
        return response()->json(['message' => 'Project deleted successfully']);
    }
}
