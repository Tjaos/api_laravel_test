<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Exception;
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

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user,
            ], 201); 

        }else{
            return response()->json([
                'status' => false,
                'message' => 'Login ou senha estão incorretos.',
            ], 404);
        }
    }
    public function logout(User $user) : JsonResponse
    {
        try{
            $user->tokens()->delete();
            
            return response()->json([
                'status' => true,
                'message' => 'Usuário deslogado com sucesso.',
            ], 200);
            
        } catch(Exception $e){

            return response()->json([
                'status' => false,
                'message' => 'Não deslogado.',
            ], 400);
        }
    }
}
