<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotaFiscalRequest;
use App\Library\AppHelper;
use App\Models\FaturamentoClientes;
use App\Models\NotaFiscal;
use App\Models\User;
use App\Models\UsuarioApi;
use Carbon\Carbon;
use Illuminate\Http\Request;

use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class NotaFiscalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $currentUserId = Auth::user()->id;
        $user = User::find($currentUserId)->roles[0]->nome;

        if($user == 'cliente'){
            $listaDeSolicitacoes = NotaFiscal::where('user_id', '=', $currentUserId)->orderBy('id', 'desc')->paginate(20);
            return view('admin.solicitacao.index', compact('listaDeSolicitacoes'));
        }

        $listaDeSolicitacoes = NotaFiscal::orderBy('id', 'desc')->paginate(20);
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
            ['url' => '', 'title' => 'Nova solicitação de Nota Fiscal'],
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
            if (!$novaNotaFiscal->setAliquota() !== false) {
                return back()->withInput()->with(['message' => 'Erro ao obter a aliquota: Existem meses que não foram encerrados', 'type' => 'error']);
            }

            if (intval($novaNotaFiscal->aliquota) === 0) {
                return back()->withInput()->with(['message' => 'Erro ao solicitar a nota: a aliquota deve ser maior que "0"', 'type' => 'error']);
            }

            $novaNotaFiscal->save();

            $usuarioApi = UsuarioApi::where('usuario', '=', AppHelper::limpaCPF_CNPJ($novaNotaFiscal->cliente->cpf_cnpj))->firstOrFail();

            $response = Http::post(env('BASE_URL_API_ROBOT') . '/login', [
                'user' => $usuarioApi->usuario,
                'password' => $usuarioApi->senha
            ]);

            $key = AppHelper::getSodiumKeyByteFromHexString(env('APP_CRYPT_KEY'));

            $aliquota = strval($novaNotaFiscal->aliquota);

            $floatAliquota = intval(explode('.', $aliquota)[1]);

            if ($floatAliquota === 0) {
                $aliquota = strval(intval($aliquota));
            }


            if (intval($aliquota) > 5) {
                $aliquota = '5';
            }

            $run = Http::withHeaders([
                'x-access-token' => $response->json()['token']
            ])->post(env('BASE_URL_API_ROBOT') . '/run', [
                'identificacao' => AppHelper::limpaCPF_CNPJ($novaNotaFiscal->cliente->usuario_ginfs),
                'password' => AppHelper::decodeString($novaNotaFiscal->cliente->senha_ginfs, $key),
                'tomador' => [
                    'cpfCnpj' => AppHelper::limpaCPF_CNPJ($novaNotaFiscal->tomador->cpf_cnpj)
                ],
                'dataEmissao' => AppHelper::formatDate(Carbon::parse($novaNotaFiscal->data_emissao)->format('Y-m-d'), 'YY-mm-dd', 'YY-MM-dd'),
                'servico' => [
                    'codigo' =>  strval($novaNotaFiscal->servico->codigo),
                    'atividade' =>  $novaNotaFiscal->servico->cod_atividade,
                    'descricao' => strval($novaNotaFiscal->observacoes),
                ],
                'aliquota' => $aliquota,
                'valor' => strval($novaNotaFiscal->valor),
                'userID' => strval($request->idCliente),
                'url' => route('saveStatus'),
                'notaID' => strval($novaNotaFiscal->id),
                'urlCidade' => $novaNotaFiscal->cliente->cidade->url_ginfes
            ]);

            return redirect('admin/solicitacao')->with(['message' => 'Nota Fiscal emitida. Em análise.', 'type' => 'sucess']);
        } catch (\Exception $e) {
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
        $solicitacao = NotaFiscal::find($idNotaFiscal);

        $parentUrl = $_SERVER['HTTP_REFERER'];
        $reversedUrl = explode('/', strrev($parentUrl), 2);
        $parentName = strrev($reversedUrl[0]);

        $breadCrumbs = [];

        switch ($parentName) {
            case 'solicitacao':
                $breadCrumbs = [
                    ['url' => '/admin/solicitacao', 'title' => 'Todas as Solicitações']
                ];
                break;
            case 'dashboard':
                $breadCrumbs = [
                    ['url' => '/admin/dashboard', 'title' => 'Dashboard']
                ];
                break;
        }

        array_push($breadCrumbs, ['url' => '', 'title' => 'Dados da Solicitação']);

        if (!is_null($solicitacao)) {
            return view('admin.solicitacao.show', compact('solicitacao', 'breadCrumbs'));
        }

        return redirect('admin/solicitacao')
            ->with(['message' => 'Nota Fiscal não encontrada.', 'type' => 'error']);
    }


    public function downloadNota($idNota)
    {
        $nota = NotaFiscal::find($idNota);
        $folderToken  = Storage::disk('notas')->directories($nota->cliente_id . '/' . $nota->numero)[0];
        $download = Storage::disk('notas')->files($folderToken)[0];
        $arrayPathFile = explode('/', $download);
        $nameFile = end($arrayPathFile);
        return response()->download(storage_path('notas/' . $download), $nameFile, ['Content-type' => 'application/pdf']);
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
            $nota->numero = $request->numeroNota;
            $nota->save();
            return response()->json([
                "message" => "Status alterado com sucesso"
            ], 201);
            //FaturamentoClientes::setFaturamento($request->id_cliente, $request->valor);
        }

        return response()->json([
            "message" => "Erro ao alterar status da nota"
        ], 401);
    }
}
