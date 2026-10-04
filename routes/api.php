<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Read all tasks
    Route::get('/tasks', function (Request $request) {
        return response()->json([
            'success' => true,
            'tasks' => $request->user()->tasks
        ]);
    });

    // Create a new task
    Route::post('/tasks', function (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'priority' => 'nullable|string',
        ]);

        $task = $request->user()->tasks()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully',
            'task' => $task
        ], 201);
    });

    // Update an existing task
    Route::put('/tasks/{id}', function (Request $request, $id) {
        $task = $request->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'priority' => 'nullable|string',
            'is_completed' => 'sometimes|boolean'
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
            'task' => $task
        ]);
    });

    // Delete a task
    Route::delete('/tasks/{id}', function (Request $request, $id) {
        $task = $request->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    });
});
