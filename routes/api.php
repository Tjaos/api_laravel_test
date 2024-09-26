<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::get('/users', [UserController::class, 'index']); //GET - http://localhost:8000/api/users

Route::post('/users', [UserController::class, 'store']); //POST -> http://localhost:8000/api/users

Route::put('/users/{user}', [UserController::class, 'update']); //PUT -> http://localhost:8000/api/users/1

Route::delete('/users/{user}', [UserController::class, 'destroy']); //DELETE -> http://localhost:8000/api/users/1

