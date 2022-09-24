<x-app-layout>
    <x-title title="Dashboard" />
    <hr>
    <div class="m-4 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 sm:gap-14 gap-5">
        @foreach ($listaDeSolicitacoes as $solicitacao)
            <a href="{{ route('solicitacao.show', $solicitacao->id) }}">
                <x-card
                    :nomeCliente="$solicitacao->cliente->razao_social"
                    :aliquota="$solicitacao->aliquota"
                    :valor="$solicitacao->valor"
                    :razaoSocial="$solicitacao->tomador->nome"
                    :statusProcessamento="$solicitacao->statusNotaFiscal->nomeStatus"
                    :dataEmissao="$solicitacao->data_emissao"
                />
            </a>
        @endforeach
    </div>
</x-app-layout>
