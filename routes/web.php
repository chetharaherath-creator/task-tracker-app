<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/insights', function () {
        $categories = ['Personal', 'Work', 'Study', 'Health'];
        $stats = [];
        
        foreach ($categories as $cat) {
            $total = auth()->user()->tasks()->where('category', $cat)->count();
            $completed = auth()->user()->tasks()->where('category', $cat)->where('is_completed', true)->count();
            $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
            
            $stats[] = [
                'name' => $cat,
                'total' => $total,
                'completed' => $completed,
                'percentage' => $percentage
            ];
        }
        
        return view('insights', compact('stats'));
    })->name('insights');

    Route::delete('/user/profile-photo', function () {
        auth()->user()->deleteProfilePhoto();
        return back()->with('status', 'profile-photo-deleted');
    })->name('current-user-photo.destroy');

    Route::delete('/user/account', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        auth()->logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('user.account.destroy');

    Route::get('/tasks/create', [\App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [\App\Http\Controllers\TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');

    // Bulletproof file serving route to bypass cloud symlink issues completely
    Route::get('/file/{path}', function ($path) {
        $fullPath = storage_path('app/public/' . $path);
        if (!file_exists($fullPath)) {
            abort(404);
        }
        return response()->file($fullPath);
    })->where('path', '.*')->name('file.serve');
});
