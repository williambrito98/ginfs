<x-app-layout>
    <x-title title="Todas as Solicitações" />
    <hr class="mb-3">

    <x-table class="rounded-xl">
        <x-slot name="columns">
            <tr>
                <th class="w-1/12 color-header-table py-2">ID</th>
                <th class="w-3/12 color-header-table">PRESTADOR</th>
                <th class="w-3/12 color-header-table">TOMADOR</th>
                <th class="w-2/12 color-header-table">VALOR</th>
                <th class="w-1/12 color-header-table">SOLICITAÇÃO</th>
                <th class="w-1/12 color-header-table">EMISSÃO</th>
                <th class="w-1/12 color-header-table">ALÍQUOTA</th>
                <th class="w-1/12 color-header-table">STATUS</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($listaDeSolicitacoes as $solicitacao)
            <tr class="border-top">
                <td class="py-4 px-1">
                    {{ $solicitacao->id }}
                </td>
                <td>
                    <a href="{{ route('solicitacao.show', $solicitacao->id) }}" class="hover:underline">
                        {{ $solicitacao->cliente->razao_social }}
                    </a>
                </td>
                <td>{{ $solicitacao->tomador->nome }}</td>
                <td>R$ {{ $solicitacao->valor ?? 0 }}</td>
                <td>{{ date('d/m/Y', strtotime($solicitacao->data_emissao)) }}</td>
                <td>{{ date('d/m/Y', strtotime($solicitacao->created_at)) }}</td>
                <td>{{ $solicitacao->aliquota ?? 0 }}%</td>
                <td>
                    @if ($solicitacao->statusNotaFiscal->nomeStatus == 'Em análise')
                    <div class="flex justify-center">
                        <x-svg.refresh />
                    </div>
                    @endif
                    @if ($solicitacao->statusNotaFiscal->nomeStatus == 'Emitida')
                    <div class="flex justify-center">
                        <x-svg.checkGreen />
                    </div>
                    @endif
                    @if ($solicitacao->statusNotaFiscal->nomeStatus == 'Cancelada')
                    <div class="flex justify-center">
                        <x-svg.canceled />
                    </div>
                    @endif
                    @if ($solicitacao->statusNotaFiscal->nomeStatus == 'Erro')
                    <div class="flex justify-center">
                        <x-svg.error />
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-table>
    {{ $listaDeSolicitacoes->appends(Request::except('page'))->render() }}
</x-app-layout>