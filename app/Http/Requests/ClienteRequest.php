<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|string|max:60',
            'email' => 'required|email|string',
            'password' => 'required',
            //'cpf_cnpj' =>  'required|string|cpf_ou_cnpj',
            'inscricao_municipal' =>  'required|string|max:60',
        ];
    }

    public function messages()
    {
        return [
            'cpf_cnpj.cpf_ou_cnpj' => 'O campo CPF/CNPJ não é um CPF ou CNPJ válido'
        ];
    }
}
