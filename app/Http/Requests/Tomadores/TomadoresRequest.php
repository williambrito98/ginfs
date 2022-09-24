<?php

namespace App\Http\Requests\Tomadores;

use Illuminate\Foundation\Http\FormRequest;

class TomadoresRequest extends FormRequest
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
            'nome' => ['required', 'string', 'max:255'],
            'inscricao_municipal' => ['required', 'string', 'max:60'],
            'cpf_cnpj' => ['required', 'string', 'formato_cpf_ou_cnpj'],
            'tipo_emissao' => ['required']
        ];
    }

    public function messages() {

        return [
            'cpf_cnpj.formato_cpf_ou_cnpj' => 'O campo CPF/CNPJ não possui o formato válido de CPF ou CNPJ.',
            'inscricao_municipal.max' => 'O campo Inscrição Municipal não pode ser maior que 60 caracteres.'
        ];
    }
}
