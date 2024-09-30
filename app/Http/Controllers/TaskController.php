<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Events\TaskCreate;
use App\Events\TaskUpdated;

class TaskController extends Controller
{
    // Display a listing of the tasks (index page)
    public function index()
    {
        // Fetch all tasks ordered by creation date (most recent first)
        $tasks = Task::where('status', '!=', 'completed')->get();

        return view('tasks.index', compact('tasks'));
    }

    // Show the form for creating a new task
    public function create()
    {
        // Return the 'tasks.create' view
        return view('tasks.create');
    }

    // Store a newly created task in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,completed,in_progress',
        ]);

        // Create a new task with the validated data
        $task = Task::create($validatedData);
        event(new TaskCreate($task));
        // Redirect to the index page with a success message
        return redirect()->route('tasks.create')->with('success', 'Task created successfully.');
    }

    // Show the form for editing the specified task
    public function edit(Task $task)
    {
        // Return the 'tasks.edit' view with the specific task data
        return view('tasks.edit', compact('task'));
    }

    // Update the specified task in the database
    public function update(Request $request, Task $task)
    {
        // Validate the updated task data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,completed,in_progress',
        ]);

        // Update the task with the new data
        $task->update($validatedData);
        event(new TaskUpdated($task));

        // Redirect to the index page with a success message
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }
}
