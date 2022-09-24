<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\AppHelper;
use Carbon\Carbon;
use DateTime;

class NotaFiscal extends Model
{
    use HasFactory;

    protected $table = 'nota_fiscal';

    protected $fillable = ['valor', 'user_id', 'cliente_id', 'tomador_id', 'status_nota_fiscal', 'data_emissao'];

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


    public function user()
    {
        return $this->hasOne(Users::class, 'user_id', 'id');
    }

    /**
     * Get aliquota from last month of the current client
     * and set aliquota value for history purposes.
     */
    public function setAliquota()
    {
        $idCliente = $this->cliente_id;

        $faturamento = FaturamentoClientes::select('aliquota', 'mes_ano_faturamento')
            ->where('clientes_id', '=', $idCliente)
            ->where('encerrado', '=', 'N')
            ->orderBy('mes_ano_faturamento', 'desc')
            ->first();

        $cliente = Clientes::find($idCliente);

        $dateNow = Carbon::now();

        $currentMonth = $dateNow->format('m');
        $currentAliquotaMonth = DateTime::createFromFormat("Y-m-d H:i:s", $faturamento->mes_ano_faturamento)->format("m");


        if (trim(strtolower($cliente->tipoEmissao->nome)) === 'seguradora') {
            $currentDay = $dateNow->format('d');
            if ($currentMonth !== $currentAliquotaMonth || !($currentDay > 5)) {
                return false;
            }
        }

        if (intval($currentMonth) !== intval($currentAliquotaMonth)) {
            return false;
        }

        if ($faturamento) {
            $this->aliquota = $faturamento->aliquota;
        } else {
            $this->aliquota = 0;
        }

        return true;
    }
}
