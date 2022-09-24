<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersTomadoresServicos extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'tomadores_id',
        'servicos_id',
        'indicador_ativo'
    ];

    public $timestamps = false;

    public $autoincrement = false;

    public $incrementing = false;
}
