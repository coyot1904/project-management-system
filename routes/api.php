<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('projects', ProjectController::class);


// Nested routes for tasks within a specific project
Route::get('projects/{project}/tasks', [TaskController::class, 'index']);
Route::apiResource('tasks', TaskController::class);

Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);



