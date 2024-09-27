<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller {

    //Lista todos os Usuarios existentes em formato JSON
    public function index() : JsonResponse{

        $users = User::orderBy('id', 'DESC')->get();
        return response()->json([
            'status'=>true,
            'users'=> $users,
        ], 200);
    }

/**
 * Cria novo usuario com os dados fornecidos na requisição.
 *
 * @param \App\Http\Requests\UserRequest $request o objeto de requisição que possui dados do usuário
 *a ser criado.
 * @return \Illuminate\Http\JsonResponse
 */
    public function store(UserRequest $request) : JsonResponse{
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

      /**
     * Editar usuário no banco de dados.
     *
     * @param \App\Models\User $user o usuario a ser editado.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user) : JsonResponse
    {
        try{
            $user->update([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return response()->json([
                'message' => 'Usuário editado com sucesso!',
                'user'=> $user->makeHidden(['password']) #oculta a senha no retorno
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'error' => 'Erro ao editar o usuário.',
                'message' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Excluir usuário no banco de dados.
     *
     * @param \App\Models\User $user o usuario a ser excluído.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( User $user) : JsonResponse
    {
        try{
            //Apaga o registro no banco de dados
            $user->delete();

            //Retorna os dados do usuario deletado e uma mensagem de sucesso!
            return response()->json([
                'message' => 'Usuário deletado com sucesso!',
                'user'=> $user->makeHidden(['password']) #oculta a senha no retorno
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'error' => 'Erro ao excluir o usuário.',
                'message' => $e->getMessage()
            ], 400);
        }


    }
    public function me(UserRequest $request){
        return response()->json($request->user());
    }
}
