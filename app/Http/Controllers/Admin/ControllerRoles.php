<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class ControllerRoles extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('ver-cargos')) {
            abort(403, 'Não Autorizado');
        }
        $roles = Roles::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function permissions($id)
    {
        if (Gate::denies('ver-permissoes')) {
            abort(403, 'Não Autorizado');
        }
        $role = Roles::find($id);
        $role->permissions = DB::table('roles')
            ->join('permissions_roles', 'permissions_roles.roles_id', '=', 'roles.id')
            ->join('permissions', 'permissions.id', '=', 'permissions_roles.permissions_id')
            ->where('roles.id', '=', $id)->get();

        $permissions = Permissions::all();

        $breadCrumbs = [
            ['url' => '/admin/papeis', 'title' => 'Cargos'],
            ['url' => '', 'title' => $role->nome],
        ];

        return view('admin.roles.permissions.index', compact('role', 'permissions', 'breadCrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('adicionar-permissoes')) {
            abort(403, 'Não Autorizado');
        }
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {

        if (Gate::denies('adicionar-cargos')) {
            abort(403, 'Não Autorizado');
        }
        try {
            $role = new Roles;
            $role->nome = $request->nome;
            $role->descricao = $request->descricao;
            $role->save();

            return redirect('admin/papeis')->with(['message' => 'Cargo cadastrado com sucesso', 'type' => 'sucess']);
        } catch (\Exception $th) {
            return redirect('admin/papeis')->with(['message' => 'Erro ao cadastrar cargo', 'type' => 'error']);
        }
    }

    public function permissionsStore(Request $request, $id)
    {

        if (Gate::denies('adicionar-permissoes')) {
            abort(403, 'Não Autorizado');
        }

        try {
            $role = Roles::find($id);
            $permission = Permissions::find($request->idItem);
            $role->createPermission($permission);
            return redirect()->back()->with(['message' => 'Permissão cadastrada com sucesso', 'type' => 'sucess']);
        } catch (\Exception $th) {
            return redirect()->back()->with(['message' => 'Erro ao cadastrar permissão', 'type' => 'error']);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('ver-cargos')) {
            abort(403, 'Não Autorizado');
        }
        $role = Roles::find($id);
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        if (Gate::denies('editar-cargo')) {
            abort(403, 'Não Autorizado');
        }
        try {
            $role = Roles::find($id);
            $role->nome = $request->nome;
            $role->descricao = $request->descricao;
            $role->save();
            return redirect('admin/papeis')->with(['message' => 'Cargo atualizado com sucesso', 'type' => 'sucess']);
        } catch (\Exception $th) {
            return redirect('admin/papeis')->with(['message' => 'Erro ao atualizar cargo', 'type' => 'error']);
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
        if (Gate::denies('deletar-cargo')) {
            abort(403, 'Não Autorizado');
        }

        try {
            DB::beginTransaction();
            foreach ($request->idItens as $key => $value) {
                Roles::where('id', '=', $value)->update(['indicador_ativo' => 'N']);
            }
            DB::commit();

            return redirect('admin/papeis')->with(['message' => 'Cargo deletado com sucesso', 'type' => 'sucess']);
        } catch (\PDOException $th) {
            DB::rollBack();
            return redirect('admin/papeis')->with(['message' => 'Erro ao deletar cargo', 'type' => 'error']);
        }
    }

    public function permissionsDestroy(Request $request)
    {
        if (Gate::denies('deletar-permissoes')) {
            abort(403, 'Não Autorizado');
        }
        try {
            $role = Roles::find($request->role_id);

            $permission = Permissions::find($request->permission_id);

            $role->removePermission($permission);

            return redirect()->back()->with(['message' => 'Permissão removida com sucesso', 'type' => 'sucess']);
        } catch (\Exception $th) {
            return redirect()->back()->with(['message' => 'Erro ao remover permissão', 'type' => 'error']);
        }
    }
}
