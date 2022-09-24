<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Library\AppHelper;
use App\Models\Clientes;
use App\Models\Roles;
use App\Models\Tomadores;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\TryCatch;

class ControllerUser extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Gate::denies('ver-usuarios')) {
            abort(403, 'Não Autorizado');
        }
        $users = User::with('roles')->whereNull('cliente_id')->where('indicador_ativo', '=', 'S')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('adicionar-usuarios')) {
            abort(403, 'Não Autorizado');
        }
        $roles = Roles::where('nome', '!=', 'cliente')->get();
        $breadCrumbs = [
            ['url' => '/admin/usuarios', 'title' => 'Usuários'],
            ['url' => '', 'title' => 'Novo Usuário'],
        ];
        return view('admin.users.create', compact('roles', 'breadCrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if (Gate::denies('adicionar-usuarios')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();
            $user = new User;
            $user->name = $request->nome;
            $user->email = $request->email;
            if ($request->password !== $request->checkPassword) {
                return redirect('admin/usuarios')->with(['message' => 'As senhas não são iguais', 'type' => 'error']);
            }
            $user->password = Hash::make($request->password);

            $role = Roles::find($request->role_id);
            $user->save();
            $user->createRole($role);
            DB::commit();
            return redirect('admin/usuarios')->with(['message' => 'Usuário adicionado com sucesso', 'type' => 'sucess']);
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect('admin/usuarios')->with(['message' => 'Erro ao adicionar usuário', 'type' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // if (Gate::denies('ver-usuarios')) {
        //     abort(403, 'Não Autorizado');
        // }
        $user = User::find($id);
        $user->role = $user->findRoleByIdUser($id);
        return view('admin.users.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('editar-usuarios')) {
            abort(403, 'Não Autorizado');
        }
        $user = User::find($id);
        $user->role = $user->findRoleByIdUser($id);
        $roles = Roles::where('nome', '!=', 'cliente')->get();
        $breadCrumbs = [
            ['url' => '/admin/usuarios', 'title' => 'Usuários'],
            ['url' => '', 'title' => $user->name],
        ];
        return view('admin.users.edit', compact('user', 'roles', 'breadCrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if (Gate::denies('editar-usuarios')) {
            abort(403, 'Não Autorizado');
        }
        $user = User::find($id);
        $user->name = $request->nome;
        $user->email = $request->email;
        $user->save();

        $role = Roles::find($request->role_id);

        $user->updateRole($role, $user->roles[0]);

        return redirect('admin/usuarios')->with(['message' => 'atualizado com sucesso', 'type' => 'sucess']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (Gate::denies('deletar-usuarios')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();
            foreach ($request->idItens as $key => $value) {
                User::where('id', '=', $value)->update(['indicador_ativo' => 'N']);
            }
            DB::commit();
        } catch (\PDOException $th) {
            DB::rollBack();
            return redirect('admin/usuarios')->with(['message' => 'Erro ao excluir usuário', 'type' => 'error']);
        }

        return redirect('admin/usuarios')->with(['message' => 'Usuário deletado com sucesso', 'type' => 'sucess']);
    
    }

    public function updateProfile(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $user->name = $request->nome;
            $user->email = $request->email;
            $user->save();

            return redirect('admin/dashboard')->with(['message' => 'atualizado com sucesso', 'type' => 'sucess']);
        } catch (\Exception $th) {
            return redirect('admin/dashboard')->with(['message' => 'Erro ao atualizar', 'type' => 'error']);    
        }
        
    }
}
