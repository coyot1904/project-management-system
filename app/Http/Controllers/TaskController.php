<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index($projectId)
    {
        return response()->json(Task::where('project_id', $projectId)->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:todo,in-progress,done',
        ]);
    
        // Create the task and associate it with the given project ID
        $task = new Task();
        $task->project_id = $request->project_id; // Assign the project ID
        $task->name = $validated['name'];
        $task->description = $validated['description'];
        $task->status = $validated['status'];
        $task->save();
    
        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return $task;
    }

    public function destroy($id)
    {
        Task::destroy($id);
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
