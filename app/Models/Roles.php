<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = ['nome', 'descricao'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class);
    }

    public function createPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permissions::where('nome', '=', $permission)->firstOrFail();
        }

        if ((bool) $this->findPermission($permission)) {
            return;
        }

        return $this->permissions()->attach($permission);
    }

    public function findPermission($permission)
    {
        return (bool) $this->permissions()->find($permission);
    }

    public function removePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permissions::where('nome', '=', $permission)->firstOrFail();
        }

        return $this->permissions()->detach($permission);
    }
}
