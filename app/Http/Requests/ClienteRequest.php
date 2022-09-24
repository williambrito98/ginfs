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
            'cpf_cnpj' =>  'required|string|cpf_ou_cnpj',
            'cidade_id' => 'required|string|max:60',
            'tipo_emissao' => 'required|string',
            'razao_social' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'cpf_cnpj.cpf_ou_cnpj' => 'O campo CPF/CNPJ não é um CPF ou CNPJ válido',
            'tipo_emissao.required' => 'O campo Tipo de Emissão é obrigatorio',
            'tipo_emissao.string' => 'O campo Tipo de Emissão não está com um formato válido',
            'razao_social.required' => 'O campo Razão social é obrigatorio'
        ];
    }
}
