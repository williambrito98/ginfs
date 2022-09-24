<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioApi extends Model
{
    use HasFactory;

    protected $table = 'usuario_api';

    protected $fillable = ['usuario', 'senha'];
}
