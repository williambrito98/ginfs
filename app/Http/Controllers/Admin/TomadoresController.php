<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TipoEmissao;
use App\Models\Tomadores;

use App\Library\AppHelper;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

use App\Http\Requests\Tomadores\TomadoresRequest;
use App\Models\Servicos;
use Illuminate\Support\Facades\Auth;

class TomadoresController extends Controller
{
    public function autocompleteSearchByCliente(Request $request, $idCliente)
    {
        $registersFound = [];
        $term = strtoupper($request->term);

        $data = Tomadores::select('tomadores.*', 'clientes.razao_social as razao_social', 'users.id as userID')
            ->join('users_tomadores', 'tomadores.id', '=', 'users_tomadores.tomadores_id')
            ->join('users', 'users.id', '=', 'users_tomadores.user_id')
            ->join('clientes', 'clientes.id', '=', 'users.cliente_id')
            ->where('clientes.id', '=', $idCliente)
            ->where('tomadores.indicador_exclusao', '!=', 'S')
            ->where('users_tomadores.indicador_ativo', '=', 'S')
            ->where('users.indicador_ativo', '=', 'S')
            ->get();

        foreach ($data as $tomador) {
            if (AppHelper::str_icontains($tomador->nome, $term)) {
                array_push($registersFound, [
                    "id" => $tomador->id,
                    "label" => $tomador->nome . ' - ' . $tomador->cpf_cnpj,
                    "nome" => $tomador->nome,
                    "cpf_cnpj" => $tomador->cpf_cnpj,
                    "inscricao_municipal" => $tomador->inscricao_municipal,
                    "listaDeServicos" => Servicos::getServicosDoTomador($idCliente, $tomador->id)
                ]);
            }
        }

        return response()->json($registersFound);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $resultsPerPage = 20;

    public function index(Request $request)
    {
        if (Gate::denies('ver-tomadores')) {
            abort(403, 'Não Autorizado');
        }

        $listaDeTomadores = [];

        $filterParameter = $request->query('filter');

        if (!empty($filterParameter)) {
            $listaDeTomadores = $this->indexFilter($filterParameter);
        } else {
            $listaDeTomadores = Tomadores::where('indicador_exclusao', '!=', 'S')
                ->sortable()
                ->paginate($this->resultsPerPage);
        }
        return view('admin.tomadores.index', compact('listaDeTomadores'))->with('filter', $filterParameter);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tiposEmissao = TipoEmissao::all();
        $breadCrumbs = [
            ['url' => '/admin/tomadores', 'title' => 'Tomadores'],
            ['url' => '', 'title' => 'Novo Tomador'],
        ];
        return view('admin.tomadores.create', compact('tiposEmissao', 'breadCrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TomadoresRequest $request)
    {
        if (Gate::denies('adicionar-tomadores')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();

            $novoTomador = new Tomadores;
            $novoTomador->nome = $request->nome;
            $novoTomador->cpf_cnpj = $request->cpf_cnpj;
            $novoTomador->inscricao_municipal = $request->inscricao_municipal;
            $novoTomador->tipo_emissaos_id = $request->tipo_emissao;
            $novoTomador->indicador_exclusao = 'N';
            $novoTomador->save();

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect('admin/tomadores')->with(['message' => 'Erro ao cadastrar tomador', 'type' => 'error']);
        }

        return redirect('admin/tomadores')->with(['message' => 'Tomador cadastrado com sucesso', 'type' => 'sucess']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idTomador)
    {
        if (Gate::denies('editar-tomadores')) {
            abort(403, 'Não Autorizado');
        }

        $tomador = Tomadores::where('id', '=', $idTomador)
            ->where('indicador_exclusao', '!=', 'S')
            ->firstOrFail();

        $tiposEmissao = TipoEmissao::all();
        $breadCrumbs = [
            ['url' => '/admin/tomadores', 'title' => 'Tomadores'],
            ['url' => '', 'title' => $tomador->nome],

        ];
        return view('admin.tomadores.edit', compact('tomador', 'tiposEmissao', 'breadCrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TomadoresRequest $request, $idTomador)
    {
        if (Gate::denies('editar-tomadores')) {
            abort(403, 'Não Autorizado');
        }
        try {

            $tomador = Tomadores::find($idTomador);

            if ($tomador->indicador_exclusao != 'S') {
                $tomador->nome = $request->nome;
                $tomador->cpf_cnpj = $request->cpf_cnpj;
                $tomador->inscricao_municipal = $request->inscricao_municipal;
                $tomador->tipo_emissaos_id = $request->tipo_emissao;
                $tomador->save();
                return redirect('/admin/tomadores')->with(['message' => 'Tomador atualizado com sucesso', 'type' => 'sucess']);
            }

            return redirect('/admin/tomadores')->with(['message' => 'Tomador indisponivel', 'type' => 'error']);
        } catch (\Exception $th) {
            return redirect('/admin/tomadores')->with(['message' => 'Erro ao atualizar tomador', 'type' => 'error']);
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

        if (Gate::denies('deletar-tomadores')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();

            foreach ($request->idItens as $key => $value) {
                Tomadores::where("id", $value)->update([
                    'indicador_exclusao' => 'S'
                ]);

                Tomadores::disableUserTomadorRelation($currentUserId, $value);
            }
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect()->back()->with(['message' => 'Erro ao deletar tomador', 'type' => 'error']);
        }
        return redirect('admin/tomadores')->with(['message' => 'Tomador deletado com sucesso', 'type' => 'sucess']);
    }

    protected function indexFilter($parameter)
    {
        $parameter = '%' . strtoupper($parameter) . '%';
        $listaDeTomadoresFiltro = [];

        $listaDeTomadoresFiltro = Tomadores::where('nome', 'ILIKE', $parameter)
            ->where('indicador_exclusao', '!=', 'S')
            ->orWhere('cpf_cnpj', 'ILIKE', $parameter)
            ->orWhere('inscricao_municipal', 'ILIKE', $parameter)
            ->sortable()
            ->paginate($this->resultsPerPage);


        return $listaDeTomadoresFiltro;
    }
}
