<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('tasks', TaskController::class);

//Route::post('/tasks', [TaskController::class, 'store'])->middleware('auth:sanctum');
//Route::get('/tasks', [TaskController::class, 'index'])->middleware('auth:sanctum');
//Route::get('/tasks/{id}', [TaskController::class, 'show'])->middleware('auth:sanctum');
//Route::put('/tasks/{id}', [TaskController::class, 'update'])->middleware('auth:sanctum');
//Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->middleware('auth:sanctum');

