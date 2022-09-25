<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicoRequest extends FormRequest
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
            'codigo' => 'required|numeric',
            'retencao_iss' => 'in:on,off'
        ];
    }

    public function messages()
    {
        return [
            'codigo.required' => 'O código é obrigatório',
            'codigo.numeric' => 'O campo Código preciso ser numérico'
        ];
    }

}
