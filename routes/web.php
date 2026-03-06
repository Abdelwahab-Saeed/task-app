<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\NoteController as AdminNoteController;
use App\Http\Controllers\Admin\MeetingController as AdminMeetingController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\TrashController as AdminTrashController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\TaskController as UserTaskController;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Tasks
    Route::resource('tasks', AdminTaskController::class);
    Route::patch('/tasks/{task}/status', [AdminTaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::post('/tasks/{task}/toggle-added', [AdminTaskController::class, 'toggleAdded'])->name('tasks.toggle-added');
    
    // Users
    Route::resource('users', AdminUserController::class);
    
    // Projects
    Route::resource('projects', AdminProjectController::class);
    
    // Notes
    Route::resource('notes', AdminNoteController::class);
    
    // Meetings
    Route::resource('meetings', AdminMeetingController::class);
    
    // Contacts
    Route::resource('contacts', AdminContactController::class);

    // Trash
    Route::get('/trash', [AdminTrashController::class, 'index'])->name('trash.index');
    Route::post('/trash/{type}/{id}/restore', [AdminTrashController::class, 'restore'])->name('trash.restore');
    Route::delete('/trash/{type}/{id}', [AdminTrashController::class, 'destroy'])->name('trash.destroy');
    Route::delete('/trash/empty', [AdminTrashController::class, 'empty'])->name('trash.empty');
});

// User Routes  
Route::prefix('user')->name('user.')->middleware(['auth', App\Http\Middleware\UserMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Tasks (read-only with status update)
    Route::get('/tasks', [UserTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}', [UserTaskController::class, 'show'])->name('tasks.show');
    Route::patch('/tasks/{task}/status', [UserTaskController::class, 'updateStatus'])->name('tasks.update-status');
    
    // TODO: Add user-specific routes for notes and meetings if needed
});
