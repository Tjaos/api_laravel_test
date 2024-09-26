<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::get('/users', [UserController::class, 'index']); //GET - http://localhost:8000/api/users

Route::post('/users', [UserController::class, 'register']); //POST -> http://localhost:8000/api/register



