<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) :JsonResponse
    {
        if(Auth::attempt([  'email' => $request->email, 'password' =>
         $request->password])){
            $user = Auth::user();
            $token =  $request->user()->createToken('api-token')->plainTextToken;
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Login ou senha estão incorretos.',
            ], 401); //Código 401 para erro do cliente(Credenciais incorretas)
        }
        return response()->json([
            'status' => true,
            'token' => $token,
            'user' => $user,
        ], 201); //Retorna código 201 para criação de token com sucesso!
    }
    public function logout() : JsonResponse
    {
        try{
            Auth::user()->tokens()->delete();
        } catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Erro ao deslogar. Tente novamente mais tarde.',
            ], 500); //Código 500 para erro interno do servidor
        }
        return response()->json([
            'status' => true,
            'message' => 'Usuário deslogado com sucesso.',
        ], 200);
    }
}
