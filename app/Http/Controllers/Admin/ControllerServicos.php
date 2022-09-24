<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServicoRequest;
use App\Library\AppHelper;
use App\Models\Servicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ControllerServicos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Gate::denies('ver-servicos')) {
            abort(403, 'Não Autorizado');
        }

        $servicos = Servicos::where('indicador_ativo', '=', 'S')->orderBy('nome')->get();



        return view('admin.servicos.index', compact('servicos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadCrumbs = [
            ['url' => '/admin/servicos', 'title' => 'Serviços'],
            ['url' => '', 'title' => 'Novo Tipo de serviço'],
        ];
        return view('admin.servicos.create', compact('breadCrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServicoRequest $request)
    {
        if (Gate::denies('adicionar-servicos')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();

            $novoServico = new Servicos();
            $novoServico->nome = $request->nome;
            $novoServico->codigo = $request->codigo;
            $novoServico->retencao_iss = $request->retencao_iss == 'on' ? true : false;
            $novoServico->indicador_ativo = 'S';
            $novoServico->cod_atividade = $request->cod_atividade;
            $novoServico->save();

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect('admin/servicos')->with(['message' => 'Erro ao cadastrar serviço', 'type' => 'error']);
        }
        return redirect('admin/servicos')->with(['message' => 'Serviço cadastrado com sucesso', 'type' => 'sucess']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('editar-servicos')) {
            abort(403, 'Não Autorizado');
        }

        $servico = Servicos::where('id', '=', $id)
            ->where('indicador_ativo', '=', 'S')
            ->firstOrFail();
        $breadCrumbs = [
            ['url' => '/admin/servicos', 'title' => 'Tipos de serviço'],
            ['url' => '', 'title' => $servico->codigo],
        ];
        return view('admin.servicos.edit', compact('servico', 'breadCrumbs'));
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
        if (Gate::denies('editar-servicos')) {
            abort(403, 'Não Autorizado');
        }

        try {
            $servico = Servicos::find($id);

            if ($servico->indicador_ativo == 'S') {
                $servico->nome = $request->nome;
                $servico->codigo = $request->codigo;
                $servico->retencao_iss = $request->retencao_iss == 'on' ? true : false;
                $servico->cod_atividade = $request->cod_atividade;
                $servico->save();
                return redirect('admin/servicos')->with(['message' => 'Serviço atualizado com sucesso', 'type' => 'sucess']);
            }

            return redirect()->with(['message' => 'Serviço indisponivel', 'type' => 'error']);
        } catch (\Exception $th) {
            return redirect()->with(['message' => 'Erro ao atualizar serviço', 'type' => 'error']);
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
        $currentUserId = Auth::user()->id;

        if (Gate::denies('deletar-servicos')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();

            foreach ($request->idItens as $key => $value) {
                Servicos::where("id", $value)->update([
                    'indicador_ativo' => 'N'
                ]);
            }

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect()->back()->with(['message' => 'Erro ao deletar serviço', 'type' => 'error']);
        }

        return redirect()->back()->with(['message' => 'Serviço deletado com sucesso', 'type' => 'sucess']);
    }
}
