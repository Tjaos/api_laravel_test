<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller {
    public function register(Request $request){
        try {
            #dataValidate
            $request->validate([
                'name'=> 'required|string|max:255',
                'lastname'=>'required|string|max:255',
                'email'=>'required|email|max:255|unique:users',
                'password'=>'required|string|min:8',
            ]);
    
            #userCreate
            $user = User::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password), 
            ]);
    
            return response()->json([
                'message' => 'Usuário cadastrado com sucesso!',
                'user'=> $user->makeHidden(['password']) #oculta a senha no retorno
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao cadastrar o usuário.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    

public function me(Request $request){
    return response()->json($request->user());
}

}
