<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\AppHelper;

use DateTime;

class NotaFiscal extends Model
{
    use HasFactory;

    protected $table = 'nota_fiscal';

    protected $fillable = ['valor', 'cliente_id', 'tomador_id', 'status_nota_fiscal', 'data_emissao'];

    protected static function boot()
    {
        parent::boot();

        NotaFiscal::saving(function ($model) {
            if (isset($model->valor)) {
                $model->valor = AppHelper::realParaNumeric($model->valor);
            }
        });

        NotaFiscal::retrieved(function ($model) {
            if (isset($model->valor)) {
                $model->valor = AppHelper::numericParaReal($model->valor);
            }
        });
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id', 'id');
    }

    public function tomador()
    {
        // por enquanto somente um tomador. mais tarde terao mais
        return $this->belongsTo(Tomadores::class, 'tomador_id', 'id');
    }

    public function servico()
    {
        return $this->hasOne(Servicos::class, 'id', 'servico_id');
    }

    public function statusNotaFiscal()
    {
        return $this->hasOne(StatusNotaFiscal::class, 'id', 'status_nota_fiscal_id');
    }

    /**
     * Get aliquota from last month of the current client
     * and set aliquota value for history purposes.
     */
    public function setAliquota()
    {
        // Get aliquota from last month of the current client
        $mes = new DateTime($this->data_emissao);
        $mes->modify('-1 month');
        $data = date($mes->format('Y-m') . '-' . '01' . ' ' . '00:00:00');
        $idCliente = $this->cliente_id;

        $faturamento = FaturamentoClientes::select('aliquota')
            ->where('mes_ano_faturamento', '=', $data)
            ->where('clientes_id', '=', $idCliente)
            ->first();

        if ($faturamento) {
            $this->aliquota = $faturamento->aliquota;
        } else {
            $this->aliquota = 0;
        }
    }
}
