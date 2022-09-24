<x-app-layout>
    <x-title title="Todas as Solicitações" />

    <br />
    <br />

    <x-table>
        <x-slot name="columns">
            <tr class="bg-btn-dropdown-client">
                <th class="w-1/12 py-3 color-header-table">Prestador</th>
                <th class="w-1/12 py-3 color-header-table">Tomador</th>                
                <th class="w-1/12 py-3 color-header-table">Valor</th>
                <th class="w-1/12 py-3 color-header-table">Data de Emissão</th>
                <th class="w-1/12 py-3 color-header-table">Data de Criação</th>
                <th class="w-1/12 py-3 color-header-table">Alíquota</th>
                <th class="w-1/12 py-3 color-header-table">Status</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($listaDeSolicitacoes as $solicitacao)
            <tr>
                <td class="py-3">
                    <a href="{{ route('solicitacao.show', $solicitacao->id) }}" class="hover:underline">
                        {{ $solicitacao->cliente->razao_social }}
                    </a>
                </td>
                <td>{{ $solicitacao->tomador->nome }}</td>
                <td>R$ {{ $solicitacao->valor ?? 0 }}</td>
                <td>{{ date('d/m/Y', strtotime($solicitacao->data_emissao)) }}</td>
                <td>{{ date('d/m/Y', strtotime($solicitacao->created_at)) }}</td>
                <td>{{ $solicitacao->aliquota ?? 0 }}%</td>
                <td>{{ $solicitacao->statusNotaFiscal->nomeStatus }}</td>
            </tr>
            @endforeach
        </x-slot>
    </x-table>
    {{ $listaDeSolicitacoes->appends(Request::except('page'))->render() }}
</x-app-layout>