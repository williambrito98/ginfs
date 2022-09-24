<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Library\AppHelper;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'indicador_ativo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        User::saving(function ($model) {
            if (isset($model->cpf_cnpj)) {
                $model->cpf_cnpj = AppHelper::limpaCPF_CNPJ($model->cpf_cnpj);
            }
        });

        User::retrieved(function ($model) {
            if (isset($model->cpf_cnpj)) {
                $model->cpf_cnpj = AppHelper::formatarCPF_CNPJ($model->cpf_cnpj);
            }
        });
    }


    public function roles()
    {
        return $this->belongsToMany(Roles::class);
    }

    public function tomadores()
    {
        return $this->hasMany(Tomadores::class, 'users_tomadores');
    }

    public static function createRelationUserTomadoresServicos($userID, $tomadorID, $servicoID)
    {
        UsersTomadoresServicos::create([
            'user_id' => $userID,
            'tomadores_id' => $tomadorID,
            'servicos_id' => $servicoID
        ]);
    }

    public static function destroyRelationUserTomadoresServicos($userID, $tomadorID, $servicoID)
    {
        UsersTomadoresServicos::where([
            'user_id' => $userID,
            'tomadores_id' => $tomadorID,
            'servicos_id' => $servicoID
        ])->update(['indicador_ativo' => 'N']);
    }


    public function clientes()
    {
        return $this->hasOne(Clientes::class, 'id', 'cliente_id');
    }

    public function servicos()
    {
        return $this->belongsToMany(servicos::class, 'users_servicos');
    }

    public function createRole($role)
    {
        if (is_string($role)) {
            $role = Roles::where('nome', '=', $role)->firstOrFail();
        }

        if ((bool) $this->findRole($role)) {
            $this->roles()->detach($role);
        }

        return $this->roles()->attach($role);
    }

    public static function getRoleByUserId($id)
    {
        return DB::table('roles')
            ->join('roles_user', 'roles.id', '=', 'roles_user.roles_id')
            ->where('roles_user.roles_id', '=', $id)
            ->first();
    }

    public function findRoleByIdUser($id)
    {
        return $this->roles()->wherePivot("user_id", '=', $id)->first();
    }

    public function findRole($role)
    {
        return (bool) $this->roles()->find($role);
    }

    public function containRole($permissions)
    {
        $userRole = $this->roles;
        return $permissions->intersect($userRole)->count();
    }

    public function isAdmin()
    {
        $role = Roles::where('nome', '=', 'Admin')->firstOrFail();
        return $this->findRole($role);
    }

    public function isActive()
    {
        if (User::where('id', '=', $this->id)->where('indicador_ativo', '=', 'S')->first()) {
            return true;
        }

        return false;
    }
}
