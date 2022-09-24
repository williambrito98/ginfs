<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\FaturamentoClientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Exception;
use App\Library\AppHelper;

class ControllerFaturamentoClientes extends Controller
{
    public function getFaturamentoAnualFromCliente($idCliente)
    {
        $registersFound = [];

        $data = FaturamentoClientes::getFaturamentoAnualVigente($idCliente);

        foreach ($data as $cliente) {
            array_push($registersFound, [
                "valor_faturamento_externo" => $cliente->valor_faturamento_externo,
                "valor_faturamento" => $cliente->valor_faturamento,
                "mes_ano_faturamento" => $cliente->mes_ano_faturamento
            ]);
        }

        return response()->json($registersFound);
    }

    public function index()
    {
        if (Gate::denies('ver-faturamento')) {
            abort(403, 'Não Autorizado');
        }

        $faturamento = [];

        $anoAtual = new DateTime('now');
        $anoPassado = clone $anoAtual;

        return view('admin.faturamento.index', compact('faturamento', 'anoAtual', 'anoPassado'));
    }

    public function store(Request $request)
    {
        if (Gate::denies('salvar-faturamento')) {
            abort(403, 'Não Autorizado');
        }

        $data = $request->all();

        $faturamentoAnualVigente = FaturamentoClientes::getFaturamentoAnualVigente($request->idCliente);

        try {
            if (!$faturamentoAnualVigente->isEmpty()) {
                $this->updateFaturamentoAnual($data);
            } else {
                $this->createFaturamentoAnual($data);
            }

            return redirect()->back()->withInput()->with(['message' => 'Faturamento cadastrado com sucesso', 'type' => 'sucess']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Erro ao cadastrar faturamento', 'type' => 'error']);
        }
    }

    protected function updateFaturamentoAnual($dataRequest)
    {
        $idCliente = $dataRequest['idCliente'];

        try {
            for ($i = 1; $i <= 12; $i++) {
                $nomeCampoFatExterno = 'totalFatExterno' . $i;
                $nomeCampoTotalMes = 'inputTotalMes' . $i;
                $nomeCampoMesAno = 'inputMesAno' . $i;

                $date = AppHelper::formatToDateMonthYearTimestamp($dataRequest[$nomeCampoMesAno]);
                $mesAnoDate = date('Y-m-d H:i:s', $date);

                FaturamentoClientes::updateOrCreate(
                    [
                        'mes_ano_faturamento' => $mesAnoDate,
                        'clientes_id' => $idCliente,
                    ],
                    [
                        'clientes_id' => $idCliente,
                        'mes_ano_faturamento' => $mesAnoDate,
                        'valor_faturamento_externo' => $dataRequest[$nomeCampoFatExterno] ?? 0,
                        'total_mes' => $dataRequest[$nomeCampoTotalMes] ?? 0
                    ]
                );
            }
        } catch (\Exception $e) {
            dd($e);
            throw new Exception('Ocorreu um erro ao cadastrar o faturamento.');
        }
    }

    protected function createFaturamentoAnual($dataRequest)
    {
        $arrayRegistros = [];

        for ($i = 1; $i <= 12; $i++) {
            $nomeCampoFatExterno = 'totalFatExterno' . $i;
            $nomeCampoFatSistema = 'inputTotalMes' . $i;
            $nomeCampoMesAno = 'inputMesAno' . $i;

            $date = AppHelper::formatToDateMonthYearTimestamp($dataRequest[$nomeCampoMesAno]);
            $now = Carbon::now()->toDateTimeString();

            array_push(
                $arrayRegistros,
                [
                    'valor_faturamento_externo' => $dataRequest[$nomeCampoFatExterno] ? AppHelper::realParaNumeric($dataRequest[$nomeCampoFatExterno]) : 0,
                    'mes_ano_faturamento' => date('Y-m-d H:i:s', $date),
                    'total_mes' => AppHelper::realParaNumeric($dataRequest[$nomeCampoFatSistema]),
                    'clientes_id' => $dataRequest['idCliente'],
                    'created_at' => $now,
                    'updated_at' => $now
                ]
            );
        }

        try {
            FaturamentoClientes::insert($arrayRegistros);
        } catch (\Exception $e) {
            dd($e);
            throw new Exception('Ocorreu um erro ao cadastrar o faturamento.');
        }
    }
}
