<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use App\Library\AppHelper;
use App\Models\Clientes;
use App\Models\FaturamentoClientes;
use App\Models\Roles;
use App\Models\Servicos;
use App\Models\Tomadores;
use App\Models\User;
use App\Models\UsuarioApi;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use DateTime;

class ControllerClientes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Gate::denies('ver-clientes')) {
            abort(403, 'Não Autorizado');
        }
        $clientes = User::join('clientes', 'users.cliente_id', '=', 'clientes.id')->where('users.indicador_ativo', 'S')->orderBy('users.id', 'DESC')->get();
        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('adicionar-clientes')) {
            abort(403, 'Não Autorizado');
        }

        $breadCrumbs = [
            ['url' => '/admin/clientes', 'title' => 'Clientes'],
            ['url' => '', 'title' => 'Adicionar Cliente'],
        ];
        return view('admin.clientes.create', compact('breadCrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('adicionar-clientes')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();
            $key = AppHelper::getSodiumKeyByteFromHexString(env('APP_CRYPT_KEY'));

            $user = new User;
            $user->name = $request->nome;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $client = new Clientes;
            $client->cpf_cnpj = AppHelper::limpaCPF_CNPJ($request->cpf_cnpj);
            $client->inscricao_municipal = $request->inscricao_municipal;
            $client->razao_social = strtoupper($request->razao_social);

            $client->usuario_ginfs = $request->usuarioGinfs;
            $client->senha_ginfs = AppHelper::encodeString($request->senhaGinfs, $key);

            $client->save();

            $usuarioApi = new UsuarioApi();
            $usuarioApi->usuario = $request->cpf_cnpj;
            $usuarioApi->senha = $user->password;
            $usuarioApi->save();

            $user->cliente_id = $client->id;
            $role = Roles::find(2);
            $user->save();
            $user->createRole($role);
            DB::commit();
        } catch (\PDOException $th) {
            dd($th);
            DB::rollBack();
            return redirect('admin/clientes')->with(['message' => 'Erro ao cadastrar cliente', 'type' => 'error']);
        } finally {
            return redirect('admin/clientes')->with(['message' => 'Cliente cadastrado com sucesso', 'type' => 'sucess']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showFaturamento($clienteId)
    {
        $faturamento = [];
        $anoAtual = new DateTime('now');
        $anoPassado = clone $anoAtual;
        $cliente = Clientes::find($clienteId);

        $breadCrumbs = [
            ['url' => '/admin/clientes', 'title' => 'Clientes'],
            ['url' => '', 'title' => $cliente->razao_social],
        ];

        return view('admin.clientes.faturamento.index', compact('clienteId', 'faturamento', 'anoAtual', 'anoPassado', 'breadCrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('editar-clientes')) {
            abort(403, 'Não Autorizado');
        }

        $cliente = User::join('clientes', 'users.cliente_id', '=', 'clientes.id')
            ->select('clientes.id', 'users.name', 'users.email', 'clientes.inscricao_municipal', 'clientes.razao_social', 'clientes.cpf_cnpj')
            ->where('users.indicador_ativo', 'S')
            ->where('clientes.id', $id)->first();

        $breadCrumbs = [
            ['url' => '/admin/clientes', 'title' => 'Clientes'],
            ['url' => '', 'title' => $cliente->razao_social],
        ];
        return view('admin.clientes.edit', compact('cliente', 'breadCrumbs'));
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
        if (Gate::denies('editar-clientes')) {
            abort(403, 'Não Autorizado');
        }

        try {
            $cpf_cnpj_limpo = AppHelper::limpaCPF_CNPJ($request->cpf_cnpj);
            $key = AppHelper::getSodiumKeyByteFromHexString(env('APP_CRYPT_KEY'));

            DB::beginTransaction();
            $cliente = Clientes::find($id);
            $cliente->cpf_cnpj = $cpf_cnpj_limpo;
            $cliente->inscricao_municipal = $request->inscricao_municipal;
            $cliente->razao_social = $request->razao_social;
            $cliente->usuario_ginfs = $request->usuarioGinfs;
            $cliente->senha_ginfs = AppHelper::encodeString($request->senhaGinfs, $key);
            $cliente->save();

            $user = User::where('cliente_id', '=', $id)->firstOrFail();

            $usuarioApi = UsuarioApi::where('usuario', '=', $cpf_cnpj_limpo)->firstOrFail();
            $usuarioApi->usuario = $cpf_cnpj_limpo;
            $usuarioApi->senha = $user->password;
            $usuarioApi->save();

            User::where('cliente_id', $id)->update(['name' => $request->nome, 'email' => $request->email]);

            DB::commit();
        } catch (\PDOException $th) {
            dd($th);
            DB::rollBack();
            return redirect()->withInput()->with(['message' => 'Erro ao atualizar cliente', 'type' => 'error']);
        } finally {
            return redirect('admin/clientes')->with(['message' => 'Cliente atualizado com sucesso', 'type' => 'sucess']);
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

        if (Gate::denies('deletar-clientes')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();

            foreach ($request->idItens as $key => $value) {
                User::where('cliente_id', '=', $value)->update(['indicador_ativo' => 'N']);
            }
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect()->back()->with(['message' => 'Erro ao deletar cliente', 'type' => 'error']);
        }

        return redirect()->back()->with(['message' => 'Cliente deletado com sucesso', 'type' => 'sucess']);
    }

    public function showTomadores($id)
    {
        if (Gate::denies('ver-relacoes-com-tomadores')) {
            abort(403, 'Não Autorizado');
        }
        $tomadores = Tomadores::where('indicador_exclusao', '!=', 'S')->get();
        $clienteTomadores = Tomadores::select('tomadores.*', 'clientes.razao_social as razao_social', 'users.id as userID')
            ->join('users_tomadores', 'tomadores.id', '=', 'users_tomadores.tomadores_id')
            ->join('users', 'users.id', '=', 'users_tomadores.user_id')
            ->join('clientes', 'clientes.id', '=', 'users.cliente_id')
            ->where('clientes.id', '=', $id)
            ->where('tomadores.indicador_exclusao', '!=', 'S')
            ->where('users_tomadores.indicador_ativo', '!=', 'N')
            ->where('users.indicador_ativo', '=', 'S')
            ->get();
        $user  = Clientes::select('users.id as userID', 'clientes.razao_social')
            ->join('users', 'users.cliente_id', '=', 'clientes.id')
            ->where('clientes.id', '=', $id)->first();
        $userID = $user->userID;
        $nomeCliente = $user->razao_social;
        foreach ($clienteTomadores as $tomador) {
            $tomador->cpf_cnpj = AppHelper::formatarCPF_CNPJ($tomador->cpf_cnpj);
        }

        $breadCrumbs = [
            ['url' => '/admin/clientes', 'title' => 'Clientes'],
            ['url' => '/admin/clientes/' . $id . '/edit', 'title' => $user->razao_social],
            ['url' => '', 'title' => 'Tomadores']
        ];

        return view('admin.clientes.tomadores.index', compact('tomadores', 'clienteTomadores', 'breadCrumbs', 'userID', 'id'));
    }
    public function storeTomadores(Request $request)
    {
        if (Gate::denies('relacionar-tomadores-aos-clientes')) {
            abort(403, 'Não Autorizado');
        }
        $tomador = Tomadores::find($request->idItem);
        try {
            $tomador->users()->attach($request->user_id);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => 'Erro ao cadastrar tomador', 'type' => 'error']);
        }

        return redirect()->back()->with(['message' => 'Tomador cadastrado com sucesso', 'type' => 'sucess']);;
    }

    public function destroyRelationTomadorUser(Request $request)
    {
        if (Gate::denies('deletar-relacionamento-tomadores-com-clientes')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();
            foreach ($request->idItens as $key => $value) {
                if (!Tomadores::disableUserTomadorRelation($request->userID, $value)) {
                    throw new Error('Erro ao deletar tomador');
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['message' => 'Erro ao deletar tomador', 'type' => 'error']);
        }
        return redirect()->back()->with(['message' => 'Tomador deletado com sucesso', 'type' => 'sucess']);
    }

    public function detailsTomador($clienteID, $tomadorID)
    {
        if (Gate::denies('ver-relacoes-com-tomadores-e-seus-servicos')) {
            abort(403, 'Não Autorizado');
        }

        $tomadorServicos = Servicos::select('servicos.*', 'clientes.razao_social as razao_social', 'users.id as userID', 'tomadores.nome as nome_tomador')
            ->join('users_tomadores_servicos', 'users_tomadores_servicos.servicos_id', '=', 'servicos.id')
            ->join('tomadores', 'tomadores.id', '=', 'users_tomadores_servicos.tomadores_id')
            ->join('users', 'users.id', '=', 'users_tomadores_servicos.user_id')
            ->leftJoin('clientes', 'clientes.id', '=', 'users.cliente_id')
            ->where('clientes.id', '=', $clienteID)
            ->where('tomadores.id', '=', $tomadorID)
            ->where('users_tomadores_servicos.indicador_ativo', '=', 'S')
            ->where('tomadores.indicador_exclusao', '!=', 'S')
            ->where('users.indicador_ativo', '=', 'S')->get();
        $servicos = Servicos::where('indicador_ativo', '=', 'S')->get();
        $user  = Clientes::select('users.id as userID', 'clientes.razao_social')
            ->join('users', 'users.cliente_id', '=', 'clientes.id')
            ->where('clientes.id', '=', $clienteID)->first();
        $id = $clienteID;
        $userID = $user->userID;

        $breadCrumbs = [
            ['url' => '/admin/clientes', 'title' => 'Clientes'],
            ['url' => '/admin/clientes/' . $id . '/edit', 'title' => $user->razao_social],
            ['url' => '/admin/clientes/' . $id . '/tomadores', 'title' => 'Tomadores'],
            ['url' => '', 'title' => count($tomadorServicos) > 0 ? $tomadorServicos[0]->nome_tomador : '']
        ];

        return view('admin.clientes.tomadores.details', compact('servicos', 'tomadorServicos', 'breadCrumbs', 'userID', 'id', 'tomadorID'));
    }

    public function storeTomadoresServicos(Request $request)
    {
        if (Gate::denies('relacionar-tomadores-aos-servicos')) {
            abort(403, 'Não Autorizado');
        }

        try {
            User::createRelationUserTomadoresServicos($request->user_id, $request->tomador_id, $request->idItem);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => 'Erro ao cadastrar serviço', 'type' => 'error']);
        }

        return redirect()->back()->with(['message' => 'Serviço cadastrado com sucesso', 'type' => 'sucess']);
    }

    public function destroyRelationTomadorServico(Request $request)
    {
        if (Gate::denies('deletar-relacionamento-tomadores-com-servicos')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();
            foreach ($request->idItens as $key => $value) {
                User::destroyRelationUserTomadoresServicos($request->userID, $request->tomador_id, $value);
            }
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect()->back()->with(['message' => 'Erro ao deletar serviço', 'type' => 'error']);
        }

        return redirect()->back()->with(['message' => 'Serviço deletado com sucesso', 'type' => 'sucess']);
    }
}
