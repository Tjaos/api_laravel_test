<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function index() : JsonResponse{

        $users = User::orderBy('id', 'DESC')->get();
        return response()->json([
            'status'=>true,
            'users'=> $users,
        ], 200);
    }


    public function register(UserRequest $request){
        try {    
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
    

}
