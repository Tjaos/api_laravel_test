<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Manipular as falhas de validação e retornar uma resposta JSON com os erros de validação.
     *
     * @param \illuminate\Contracts\Validation\Validator  $validator -> o objeto de validação que contém os erros de validação
     *
     * @throws \illuminate\Http\Exceptions\HttpResponseException
     */

     protected function failedValidation(Validator $validator)
     {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'erros' => $validator->errors(),
        ], 422)); //O código de status 422 significa "Unprocessable Entity". É usado quando o servidor entende a requisição do cliente, mas não pode processá-la por erros de validação.
     }


    public function rules(): array
    {
        #resgata o id do usuário
        $userId = $this->route('user');
        return [
            'name'=> 'required|string|max:255',
            'lastname'=>'required|string|max:255',
            'email'=>'required|email|max:255|unique:users,email,' . ($userId ? $userId ->id : null),
            'password'=>'required|string|min:8',

        ];
    }

    /**
     * Retorna as mensagens de erro personalizadas para as regras de validação.
     *
     * @return array
     */
    public function messages():array{
        return [
            'name.required' => 'Campo nome é obrigatório!',
            'email.required' => 'Campo e-mail é obrigatório!',
            'email.email' => 'Formato de e-mail inválido!',
            'email.unique' => 'O e-mail já está cadastrado!',
            'password.required' => 'A senha é obrigatória!',
            'password.min' => 'Senha com no mínimo :min caracteres!',


        ];
    }
}
