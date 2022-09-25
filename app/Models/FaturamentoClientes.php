<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use App\Library\AppHelper;
use Carbon\Carbon;
use Exception;
use Kyslik\ColumnSortable\Sortable;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

use Illuminate\Support\Facades\DB;

class FaturamentoClientes extends Model
{
    use HasFactory;

    use Sortable;

    protected $table = 'faturamento_clientes';

    protected $fillable = ['clientes_id', 'mes_ano_faturamento', 'valor_faturamento_externo', 'valor_faturamento', 'total_mes', 'quantidade_emissoes', 'encerrado'];

    public $sortable = ['mes_ano_faturamento', 'valor_faturamento_externo', 'valor_faturamento', 'total_mes', 'quantidade_emissoes', 'encerrado'];

    protected static function boot()
    {
        parent::boot();

        FaturamentoClientes::saving(function ($model) {
            if (isset($model->total_mes)) {
                $model->total_mes = AppHelper::realParaNumeric($model->total_mes);
            }

            if (isset($model->valor_faturamento_externo)) {
                $model->valor_faturamento_externo = AppHelper::realParaNumeric($model->valor_faturamento_externo);
            }

            if (isset($model->valor_faturamento)) {
                $model->valor_faturamento = AppHelper::realParaNumeric($model->valor_faturamento);
            }
        });

        FaturamentoClientes::retrieved(function ($model) {
            if (isset($model->total_mes)) {
                $model->total_mes = AppHelper::numericParaReal($model->total_mes);
            }

            if (isset($model->valor_faturamento_externo)) {
                $model->valor_faturamento_externo = AppHelper::numericParaReal($model->valor_faturamento_externo);
            }

            if (isset($model->valor_faturamento)) {
                $model->valor_faturamento = AppHelper::numericParaReal($model->valor_faturamento);
            }

            if (is_null($model->quantidade_emissoes)) {
                $model->quantidade_emissoes = 0;
            }

            if (is_null($model->encerrado)) {
                $model->encerrado = 'N';
            }

            if (is_null($model->aliquota)) {
                $model->aliquota = 0;
            }
        });
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id', 'id');
    }



    public function razaoSocialSortable($query, $direction)
    {
        return $query->join('clientes', 'faturamento_clientes.clientes_id', '=', 'clientes.id')
            ->orderBy('clientes.razao_social', $direction)
            ->select('faturamento_clientes.*');
    }

    public function encerrarFaturamento()
    {
        try {
            DB::beginTransaction();

            $this->encerrado = 'S';
            $this->save();
            $novaDataMesAno = (new DateTime($this->mes_ano_faturamento))
                ->modify('+1 month')
                ->format('Y-m-d H:i:s');
            $novoFaturamento = FaturamentoClientes::where('mes_ano_faturamento', $novaDataMesAno)->first();
            if (!$novoFaturamento) {
                $novoFaturamento = new FaturamentoClientes();
                $novoFaturamento->mes_ano_faturamento = $novaDataMesAno;
            }
            /* Regra de negocio: ao encerrar um faturamento
            criar novo registro para o mes seguinte*/
            //$novoFaturamento = new FaturamentoClientes();
            $novoFaturamento->clientes_id = $this->clientes_id;
            $novoFaturamento->encerrado = 'N';
            $novoFaturamento->valor_faturamento_externo = 0;
            $novoFaturamento->valor_faturamento = 0;
            $novoFaturamento->total_mes = 0;
            $novoFaturamento->quantidade_emissoes = 0;
            $novoFaturamento->calcularAliquota();

            $novoFaturamento->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            throw new Exception('Ocorreu um erro ao encerrar o faturamento.');
        }
    }

    public static function getAllListaFechamentoMensal()
    {
        return FaturamentoClientes::sortable(['mes_ano_faturamento' => 'desc'])
            ->paginate(20);
    }

    public static function getFaturamentoAnualVigente($idCliente)
    {
        return FaturamentoClientes::where('clientes_id', '=', $idCliente)
            ->orderBy('mes_ano_faturamento', 'DESC')
            ->limit(12)
            ->get();
    }

    static public function createFaturamentoAnualEntries($idCliente)
    {
        $arrayRegistros = [];
        for ($i = 0; $i <= 12; $i++) {
            $now = Carbon::now();
            $newDate = date($now->subMonth($i)->format('Y-m')  . '-' . '01' . ' ' . '00:00:00');
            array_push(
                $arrayRegistros,
                [
                    'valor_faturamento_externo' => 0,
                    'mes_ano_faturamento' => $newDate,
                    'total_mes' => 0,
                    'clientes_id' => $idCliente,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                    'encerrado' => $i === 0 ? 'N' : 'S'
                ]
            );
        }

        try {
            FaturamentoClientes::insert($arrayRegistros);
        } catch (\Exception $e) {
            throw new Exception('Ocorreu um erro ao criar entradas do faturamento.');
        }
    }

    public function calcularAliquota()
    {
        /*
        FT12 - Faturamento dos últimos 12 meses (ano calendário)
        IND  - Índice (alíquota) do anexo (aquela que ta cadastrada na tabela. campo indice)
        FR - Fator redutor (cadastrado na tabela também)

        A fórmula:
        [(FT12 x IND) – FR] ÷ FT12 resulta no valor da alíquota a ser usada no próximo mês
        */

        $numberFormatter = new \NumberFormatter('pt_BR', \NumberFormatter::DECIMAL);
        $currencies = new ISOCurrencies();
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);


        //somar os ultimos 12 faturamentos
        $ultimosDozeFaturamentos = FaturamentoClientes::where('clientes_id', '=', $this->clientes_id)
            ->where('encerrado', '=', 'S')
            ->limit(12)
            ->orderBy('mes_ano_faturamento', 'desc')
            ->get();
        $valorTotalDozeFaturamentos = Money::BRL(0);
        foreach ($ultimosDozeFaturamentos as $faturamento) {
            if ($faturamento->total_mes != '0,00') {
                $valor = preg_replace('/[^0-9,]/s', '', $faturamento->total_mes);
                $valor = str_replace(',', '', $valor);

                $valorASomar = new Money($valor, new Currency('BRL'));
                $valorTotalDozeFaturamentos = $valorTotalDozeFaturamentos->add($valorASomar);
            }
        }

        // Busca e seta as variaveis
        $formulas = Formulas::getValoresDeQuantia($moneyFormatter->format($valorTotalDozeFaturamentos));
        $indice = strval($formulas->indice / 100);

        $fatorRedutor = $formulas->fator_redutor;
        $issRetido = strval($formulas->iss_retido_das / 100);

        $valorTotalMeses = AppHelper::realParaNumeric($moneyFormatter->format($valorTotalDozeFaturamentos));

        //  [(FT12 x IND) – FR]
        $produtoValorAliquota = strval($valorTotalMeses * $indice);

        $produtoValorAliquota = number_format($produtoValorAliquota, 2);

        $produtoValorAliquota = str_replace(',', '', $produtoValorAliquota);
        $produtoValorAliquota = str_replace('.', '', $produtoValorAliquota);

        $fatorRedutor = str_replace('.', '', $fatorRedutor);

        $produtoValorAliquota = strval(intval($produtoValorAliquota, 10));


        $prodValorAliquota = new Money($produtoValorAliquota, new Currency('BRL'));

        if (intval($fatorRedutor) == 0) {
            $calculoFaturamentoAliquotaFatorRedutor = $prodValorAliquota;
        } else {
            $precoValorRedutor = new Money($fatorRedutor, new Currency('BRL'));
            $calculoFaturamentoAliquotaFatorRedutor = $prodValorAliquota->subtract($precoValorRedutor);
        }

        // [(FT12 x IND) – FR] ÷ FT12
        if ((float)$valorTotalMeses == 0) {
            $valorTotalMeses = "0";
            $valorTotalDozeFaturamentos = str_replace('.', '', $valorTotalMeses);
            $valorTotalDozeFat = new Money($valorTotalDozeFaturamentos, new Currency('BRL'));

            $aliquotaProximoMes = $calculoFaturamentoAliquotaFatorRedutor->getAmount() * 100;
            $aliquotaProximoMes = $aliquotaProximoMes * $issRetido;

            $aliquota = round($aliquotaProximoMes, 2);

            if ($aliquota === 2.01) {
                $this->aliquota = 2;
                return true;
            }

            if ($aliquota > 5) {
                $this->aliquota = 5;
                return true;
            }

            if ($aliquota <= 0) {
                $this->aliquota = 2;
                return true;
            }

            $this->aliquota = round($aliquotaProximoMes, 2);

            return true;
        }

        $valorTotalDozeFaturamentos = str_replace('.', '', $valorTotalMeses);
        $valorTotalDozeFat = new Money($valorTotalDozeFaturamentos, new Currency('BRL'));
        $aliquotaProximoMes = ($calculoFaturamentoAliquotaFatorRedutor->getAmount() / $valorTotalDozeFat->getAmount()) * 100;
        $aliquotaProximoMes = $aliquotaProximoMes * $issRetido;
        $aliquota = round($aliquotaProximoMes, 2);

        if ($aliquota === 2.01) {
            $this->aliquota = 2;
            return true;
        }

        if ($aliquota > 5) {
            $this->aliquota = 5;
            return true;
        }

        if ($aliquota <= 0) {
            $this->aliquota = 2;
            return true;
        }

        $this->aliquota = round($aliquotaProximoMes, 2);

        return true;
    }

    // public static function setFaturamento($idCliente, $valor)
    // {
    //     $getLastMounth = FaturamentoClientes::where('encerrado', '=', 'N')->select('mes_ano_faturamento')->first();
    //     $faturamento = FaturamentoClientes::where('clientes_id', '=', $idCliente)->where('mes_ano_faturamento', '=', $getLastMounth->mes_ano_faturamento)->first();
    //     $faturamento->valor_faturamento = floatval($valor) + $faturamento->original['valor_faturamento'];
    //     $faturamento->quantidade_emissoes++;
    //     $faturamento->total_mes = floatval($valor) + $faturamento->original['valor_faturamento_externo'];
    //     $faturamento->save();
    // }
}
