<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidades extends Model
{
    use HasFactory;

    protected $table = 'cidades';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nome',
        'url_ginfes'
    ];


    public function Clientes() {
        return $this->belongsTo(Clientes::class, 'clientes_id', 'id');
    }
}
