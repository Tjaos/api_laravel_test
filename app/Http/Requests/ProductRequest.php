<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
       ], 422));

    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'O nome do produto é obrigatório!',
            'price.required' => 'O preço é obrigatório!',
        ];
    }
}
