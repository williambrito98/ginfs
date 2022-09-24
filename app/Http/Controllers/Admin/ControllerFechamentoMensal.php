<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaturamentoClientes;

use Illuminate\Http\Request;

class ControllerFechamentoMensal extends Controller
{
    public function index(Request $request)
    {
        $filterIniDate = '';
        $filterFinalDate = '';
        $listaDeFaturamentos = [];

        $filterParameter = $request->query('filter');

        if (!is_null($request->query('dataInicial'))) {
            $filterIniDate = $request->query('dataInicial') . '-01 00:00:00';
        }

        if (!is_null($request->query('dataFinal'))) {
            $filterFinalDate = $request->query('dataFinal') . '-01 00:00:00';
        }

        if (!empty($filterParameter) || $filterIniDate != '' || $filterFinalDate != '') {
            $listaDeFaturamentos = $this->indexFilter($filterParameter, $filterIniDate, $filterFinalDate);
        } else {
            $listaDeFaturamentos = FaturamentoClientes::getAllListaFechamentoMensal();
        }

        return view('admin.fechamentomensal.index', compact('listaDeFaturamentos'))->with('filter', $filterParameter);
    }

    public function encerrarFaturamentoMes($idFaturamento)
    {
        try {
            $faturamento = FaturamentoClientes::find($idFaturamento);
            $faturamento->encerrarFaturamento();
            return back()->with('success', 'Faturamento encerrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    protected function indexFilter($parameter, $initialDate = '', $finalDate = '')
    {
        $parameter = '%' . strtoupper($parameter) . '%';
        try {
            if ($parameter == '%%' && ($initialDate != '' || $finalDate != '')) {
                return FaturamentoClientes::select('faturamento_clientes.*', 'clientes.razao_social', 'clientes.cpf_cnpj')
                    ->join('clientes', 'faturamento_clientes.clientes_id', '=', 'clientes.id')
                    ->whereBetween('mes_ano_faturamento', [$initialDate, $finalDate])
                    ->sortable()
                    ->paginate(20);
            }

            if ($parameter !== '%%' && ($initialDate == '' && $finalDate == '')) {
                return FaturamentoClientes::select('faturamento_clientes.*', 'clientes.razao_social', 'clientes.cpf_cnpj')
                    ->join('clientes', 'faturamento_clientes.clientes_id', '=', 'clientes.id')
                    ->orWhere('clientes.razao_social', 'ILIKE', $parameter)
                    ->orWhere('clientes.cpf_cnpj', 'ILIKE', $parameter)
                    ->sortable()
                    ->paginate(20);
            }

            return FaturamentoClientes::select('faturamento_clientes.*', 'clientes.razao_social', 'clientes.cpf_cnpj')
                ->join('clientes', 'faturamento_clientes.clientes_id', '=', 'clientes.id')
                ->whereBetween('mes_ano_faturamento', [$initialDate, $finalDate])
                ->where('clientes.razao_social', 'ILIKE', $parameter)
                ->orWhere('clientes.cpf_cnpj', 'ILIKE', $parameter)
                ->sortable()
                ->paginate(20);
        } catch (\Exception $e) {
            //dd($e);
            return redirect('admin.fechamentomensal.index')
                ->withErrors(['errors' => 'Ocorreu um erro ao buscar faturamento.']);
        }
    }
}
