<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::get('/users', function (Request $request) {
    return response()->json([
        'status'=>true,
        'message'=> 'Listar Usuários',
    ], 200);
});


Route::post('/register', [UserController::class, 'register']);