<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusNotaFiscal extends Model
{
    use HasFactory;

    protected $table = 'status_nota_fiscal';

    public function notaFiscal()
    {
        return $this->belongsTo(NotaFiscal::class);
    }
}
