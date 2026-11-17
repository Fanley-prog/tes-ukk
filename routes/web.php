<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/process', [AdminController::class, 'process'])->name('login.process');

Route::middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    
    Route::get('/add', [AdminController::class, 'add']);
    Route::post('/add', [AdminController::class, 'store']);

    Route::delete('/delete/{id}', [AdminController::class, 'delete']);

    Route::get('/edit/{id}', [AdminController::class, 'edit']);
    Route::put('/edit/{id}', [AdminController::class, 'update']);
    
    Route::get('/settings', [AdminController::class, 'editSettings'])->name('settings.edit');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    
    });

Route::get('/template1/{slug}', [WebsiteController::class, 'template1']);