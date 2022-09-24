<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Formulas;
use Exception;
use Illuminate\Support\Facades\DB;

class ControllerFormulas extends Controller
{
    public function index()
    {
        $listaDeFormulas = Formulas::all();

        return view('admin.formulas.index', compact('listaDeFormulas'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            if (count($request->valor_minimo) > 0) {
                foreach ($request->valor_minimo as $key => $value) {
                    Formulas::updateOrCreate(
                        [
                            'valor_minimo' => $request->valor_minimo[$key]
                        ],
                        [
                            'valor_minimo' => $request->valor_minimo[$key],
                            'valor_maximo' => $request->valor_maximo[$key],
                            'indice' => $request->indice[$key],
                            'fator_redutor' => $request->fator_redutor[$key],
                            'iss_retido_das' => $request->iss_retido_das[$key],
                        ]
                    );
                }
            }
            DB::commit();
            return redirect()->back()->withInput()->with(['message' => 'Formula cadastrado com sucesso', 'type' => 'sucess']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['message' => 'Erro ao cadastrar formula', 'type' => 'error']);
        }
    }
}
