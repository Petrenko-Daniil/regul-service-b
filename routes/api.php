<?php

use Illuminate\Support\Facades\Route;

Route::resource('tasks', \App\Http\Controllers\TaskController::class);
Route::resource('categories', \App\Http\Controllers\CategoryController::class);
