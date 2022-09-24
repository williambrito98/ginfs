<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotaFiscalRequest;
use App\Library\AppHelper;
use App\Models\NotaFiscal;
use App\Models\UsuarioApi;
use Carbon\Carbon;
use Illuminate\Http\Request;

use DateTime;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class NotaFiscalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaDeSolicitacoes = NotaFiscal::paginate(20);

        return view('admin.solicitacao.index', compact('listaDeSolicitacoes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadCrumbs = [
            ['url' => '/admin/solicitacao', 'title' => 'Todas as Solicitações'],
            ['url' => '', 'title' => 'Solicitação de NF'],
        ];

        return view('admin.solicitacao.create', compact('breadCrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotaFiscalRequest $request)
    {
        try {
            $novaNotaFiscal = new NotaFiscal();
            $novaNotaFiscal->valor = $request->valorNota;
            $novaNotaFiscal->cliente_id = $request->idCliente;
            $novaNotaFiscal->tomador_id = $request->idTomador;
            $novaNotaFiscal->status_nota_fiscal_id = 2; //Em analise
            $novaNotaFiscal->data_emissao = $request->dataEmissao;
            $novaNotaFiscal->servico_id = $request->tipoServico;
            $novaNotaFiscal->observacoes = $request->observacoes == '' ? null : $request->observacoes;
            $novaNotaFiscal->setAliquota();
            $novaNotaFiscal->save();

            // const dataWorker = {
            //     identificacao: '18548754000146',
            //     password: '218332CAJ7524',
            //     tomador: {
            //       cpfCnpj: '00632587000151'
            //     },
            //     dataEmissao: '30-07-2021',
            //     servico: {
            //       codigo: '2001',
            //       atividade: '523110100',
            //       descricao: 'descricao'
            //     },
            //     aliquota: '2',
            //     valor: '0.01',
            //     email: '',
            //     routeStatus: '',
            //     userID: '1'
            //   }


            $usuarioApi = UsuarioApi::where('usuario', '=', AppHelper::limpaCPF_CNPJ($novaNotaFiscal->cliente->cpf_cnpj))->firstOrFail();

      

            $response = Http::post('http://localhost:3333/login', [
                'user' => $usuarioApi->usuario,
                'password' => $usuarioApi->senha
            ]);


            $run = Http::withHeaders([
                'x-access-token' => $response->json()['token']
            ])->post('http://localhost:3333/run', [
                'identificacao' => AppHelper::limpaCPF_CNPJ($novaNotaFiscal->cliente->usuario_ginfs),
                'password' => Crypt::decryptString($novaNotaFiscal->cliente->senha_ginfs),
                'tomador' => [
                    'cpfCnpj' => '00632587000151'
                ],
                'dataEmissao' => Carbon::parse($novaNotaFiscal->data_emissao)->format('d-m-Y'),
                'servico' => [
                    'codigo' =>  '2001',//$novaNotaFiscal->servico->codigo,
                    'atividade' => '523110100',
                    'descricao' => $novaNotaFiscal->observacoes,
                ],
                'aliquota' => '2',
                'valor' => $novaNotaFiscal->valor,
                'userID' => $request->idCliente
            ]);




            return redirect('admin/solicitacao')->with(['message' => 'Nota Fiscal emitida. Em análise.', 'type' => 'sucess']);
        } catch (\Exception $e) {
            dd($e);
            return back()->withInput()->with(['message' => 'Erro ao emitir Nota Fiscal', 'type' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotaFiscal  $notaFiscal
     * @return \Illuminate\Http\Response
     */
    public function show($idNotaFiscal)
    {
        $breadCrumbs = [
            ['url' => '/admin/solicitacao', 'title' => 'Todas as Solicitações'],
            ['url' => '', 'title' => 'Dados da Solicitação']
        ];

        $solicitacao = NotaFiscal::find($idNotaFiscal);

        if (!is_null($solicitacao)) {
            return view('admin.solicitacao.show', compact('solicitacao', 'breadCrumbs'));
        }

        return redirect('admin/solicitacao')
            ->with(['message' => 'Nota Fiscal não encontrada.', 'type' => 'error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotaFiscal  $notaFiscal
     * @return \Illuminate\Http\Response
     */
    public function edit(NotaFiscal $notaFiscal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NotaFiscal  $notaFiscal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotaFiscal $notaFiscal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotaFiscal  $notaFiscal
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotaFiscal $notaFiscal)
    {
        //
    }

    public function saveStatus(Request $request)
    {
        $nota = NotaFiscal::find($request->notaID);
        if ($nota) {
            $nota->status_nota_fiscal_id = $request->statusNota;
            $nota->save();
            return response()->json([
                "message" => "Status alterado com sucesso"
            ], 201);
        }

        return response()->json([
            "message" => "Erro ao alterar status da nota"
        ], 401);
      
    }
}
