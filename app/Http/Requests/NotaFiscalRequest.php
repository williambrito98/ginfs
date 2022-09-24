<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaFiscalRequest extends FormRequest
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
            'nome_cliente' => 'required|string',
            'cpf_cnpj' => 'required|string|formato_cpf_ou_cnpj',
            'busca-tomador' => 'required|string',
            'cpf_cnpj_tomador' => 'required|string|formato_cpf_ou_cnpj',
            'idCliente' => 'required|integer',
            'idTomador' => 'required|integer',
            'tipoServico' => 'required|integer',
            'dataEmissao' => 'required|date',
            'valorNota' => 'required|string',
            'observacoes' => 'max:255'
        ];
    }

    public function messages()
    {
        return [
            'cpf_cnpj.formato_cpf_ou_cnpj' => 'O campo CPF/CNPJ não é um CPF ou CNPJ válido',
            'cpf_cnpj.required' => 'O campo CPF/CNPJ é obrigatório',
            'nome_cliente.required' => 'O campo Emissor é obrigatório.',
            'busca-tomador.required' => 'O campo Tomador é obrigatório.',
            'cpf_cnpj_tomador.formato_cpf_ou_cnpj' => 'O campo CPF/CNPJ não é um CPF ou CNPJ válido',
            'cpf_cnpj_tomador.required' => 'O campo CPF/CNPJ é obrigatório',
            'valorNota.required' => 'O campo Valor Nota é obrigatório.',
            'observacoes.max' => 'O campo Observações pode conter no máximo 255 caracteres.'
        ];
    }
}
