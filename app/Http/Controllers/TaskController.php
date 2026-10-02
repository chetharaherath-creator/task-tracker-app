<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('tasks-create');
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'attachment' => 'nullable|image|max:5120' // Max 5MB images
        ]);
        
        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }
        
        auth()->user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category ?? 'Personal',
            'priority' => $request->priority ?? 'Medium',
            'due_date' => $request->due_date ?? now(),
            'is_completed' => false,
            'attachment_path' => $path,
        ]);
        
        return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        // Security check: ensure user can only edit their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('tasks-edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Security check: ensure user can only update their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate(['title' => 'required|string|max:255']);
        
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category ?? 'Personal',
            'priority' => $request->priority ?? 'Medium',
            'due_date' => $request->due_date ?? now(),
        ]);
        
        return redirect()->route('dashboard');
    }
}
