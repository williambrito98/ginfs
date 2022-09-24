<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Dashboard
                </div>
            </div>
                <div class="m-4 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 sm:gap-14 gap-5">
                @foreach ($listaDeSolicitacoes as $solicitacao)
                    <x-card 
                        :nomeCliente="$solicitacao->cliente->razao_social"
                        :razaoSocial="$solicitacao->tomador->nome"
                        :aliquota="$solicitacao->aliquota"
                        :valor="$solicitacao->valor"
                        :statusProcessamento="$solicitacao->statusNotaFiscal->nomeStatus"
                        :dataEmissao="$solicitacao->data_emissao"
                    />
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
