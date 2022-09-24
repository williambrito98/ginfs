<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\AppHelper;

class Formulas extends Model
{
    use HasFactory;

    protected $table = 'formulas';

    protected $fillable = ['valor_minimo', 'valor_maximo', 'indice', 'fator_redutor', 'iss_retido_das'];

    public static function getValoresDeQuantia($quantiaEmReais)
    {
        $quantia = AppHelper::realParaNumeric($quantiaEmReais);
        return Formulas::select('indice', 'fator_redutor', 'iss_retido_das')
            ->where('valor_minimo', '<=', $quantia)
            ->where('valor_maximo', '>=', $quantia)->first();
    }
}
