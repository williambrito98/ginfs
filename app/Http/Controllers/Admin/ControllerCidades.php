<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cidades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ControllerCidades extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cidades = Cidades::where('indicador_ativo', '=', 'S')->get();

        return view('admin.cidades.index', compact('cidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('adicionar-cidades')) {
            abort(403, 'Não Autorizado');
        }

        $breadCrumbs = [
            ['url' => route('cidades.index') , 'title' => 'Cidades'],
            ['url' => '', 'title' => 'Nova Cidades'],
        ];
        return view('admin.cidades.create', compact('breadCrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('adicionar-cidades')) {
            abort(403, 'Não Autorizado');
        }
        try {

            $cidade = new Cidades();
            $cidade->nome = $request->nome;
            $cidade->url_ginfes = $request->urlGinfes;

            $cidade->save();

            return redirect('admin/cidades')->with(['message' => 'Cidade cadastrado com sucesso', 'type' => 'sucess']);
        } catch (\Exception $th) {

            return redirect('admin/cidades')->with(['message' => 'Erro ao cadastrar cidade', 'type' => 'error']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('editar-cidades')) {
            abort(403, 'Não Autorizado');
        }
        $cidade = Cidades::find($id);
        $breadCrumbs = [
            ['url' => route('cidades.index'), 'title' => 'Cidades'],
            ['url' => '', 'title' => $cidade->nome],
        ];
        return view('admin.cidades.edit', compact('cidade', 'breadCrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('editar-cidades')) {
            abort(403, 'Não Autorizado');
        }

        try {
            $cidade = Cidades::find($id);
            $cidade->nome = $request->nome;
            $cidade->url_ginfes = $request->urlGinfes;
            $cidade->save();

            return redirect('admin/cidades')->with(['message' => 'Cidade atualizada com sucesso', 'type' => 'sucess']);
        } catch (\Exception $th) {
            return redirect('admin/cidades')->with(['message' => 'Erro ao atualizar cidade', 'type' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (Gate::denies('deletar-cidades')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();

            foreach ($request->idItens as $key => $value) {
                Cidades::where('id', '=', $value)->update(['indicador_ativo' => 'N']);
            }
            DB::commit();
            return redirect('admin/cidades')->with(['message' => 'Cidade deletada com sucesso', 'type' => 'sucess']);
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect()->back()->with(['message' => 'Erro ao deletar cliente', 'type' => 'error']);
        }
    }
}
