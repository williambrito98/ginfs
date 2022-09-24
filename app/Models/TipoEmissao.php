<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEmissao extends Model
{
    use HasFactory;

    public function tomadores()
    {
        return $this->belongsTo(Tomadores::class, 'tipo_emissaos_id', 'id');
    }
}
