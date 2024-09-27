<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;


//Rota pública de login:
Route::post('/', [LoginController::class, 'login'])->name('login');

Route::get('users', [UserController::class, 'index']); //GET - http://localhost:8000/api/users
Route::post('/users', [UserController::class, 'store']); //POST -> http://localhost:8000/api/users

//Rotas restrita
Route::group(['middleware' => ['auth:sanctum']], function(){


    Route::put('/users/{user}', [UserController::class, 'update']); //PUT -> http://localhost:8000/api/users/1

    Route::post('logout/{user}', [LoginController::class, 'logout']); //POST -> http://localhost:8000/api/logout/1

    Route::delete('/users/{user}', [UserController::class, 'destroy']); //DELETE -> http://localhost:8000/api/users/1
});

    //Rota p[ublica do produto
    Route::get('/products', [ProductController::class, 'index']);

    //Rotas restritas do produto
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

});





