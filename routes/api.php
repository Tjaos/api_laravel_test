<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;


//Rota pública de login:
Route::post('/', [LoginController::class, 'login'])->name('login');

Route::post('/users', [UserController::class, 'store']); //POST -> http://localhost:8000/api/users
Route::get('users', [UserController::class, 'index']); //GET - http://localhost:8000/api/users


//Rota pública do produto
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('show');



//Rotas restrita
Route::middleware('auth:sanctum')->group(function(){

    //Rotas restritas de Usuários
    Route::put('/users/{user}', [UserController::class, 'update']); //PUT -> http://localhost:8000/api/users/1

    Route::post('logout/{user}', [LoginController::class, 'logout']); //POST -> http://localhost:8000/api/logout/1

    Route::delete('/users/{user}', [UserController::class, 'destroy']); //DELETE -> http://localhost:8000/api/users/1



    //Rotas restritas do produto
    Route::post('/products', [ProductController::class, 'store']);

    Route::put('/products/{product}', [ProductController::class, 'update']);

    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
});









