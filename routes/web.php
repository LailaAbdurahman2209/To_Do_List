<?php

use App\Mail\TestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TodoController; 
use Laravel\Jetstream\Http\Controllers\CurrentTeamController;

// 1. All Authenticated & Protected Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'cache.headers:private;max_age=0;must_revalidate' 
])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Teams
    Route::put('/current-team', function (Request $request) {
        app(CurrentTeamController::class)->update($request);
        return redirect()->back(303);
    })->name('current-team.update');

    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->middleware('can:manage-operations');
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');

    // Users
    Route::get('/users/export', [UserController::class, 'exportCsv'])->name('users.export');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::resource('users', UserController::class);

    // --- TO-DO LIST ROUTES ---
    // This allows your nav link to work
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');


    Route::get('/todos/{todo}/set-reminder/{minutes}', [App\Http\Controllers\TodoController::class, 'setReminder'])->name('todos.set-reminder');
    
    // This handles the form page and the saving of data
    Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
    Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');

    // Logout Route
    Route::post('/logout', function () {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login'); 
    })->name('logout');
}); 

// 2. Public / Unauthenticated Routes
Route::get('/send-test-email', function () {
    Mail::to('lailaabdurahman2206@gmail.com')->send(new TestEmail());
    return 'Test email sent!';
});