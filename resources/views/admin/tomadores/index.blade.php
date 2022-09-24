<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <x-title title="Tomadores" />
    <hr>
    @can('adicionar-tomadores')
        <x-add-register :route="route('tomadores.create')" />
    @endcan
    @can('deletar-tomadores')
        <x-delete-register :route="route('tomadores.destroy')" />
    @endcan

    <x-table class="my-16">
        <x-slot name="columns">
            <tr class="bg-btn-dropdown-client">
                <th class="w-1/4 p-3 color-header-table showDelete">
                    <input type="checkbox" id="selectAll">
                </th>
                <th class="w-1/4 color-header-table">@sortablelink('nome', 'Nome')</th>
                <th class="w-1/4 color-header-table">CNPJ</th>
                <th class="w-1/4 color-header-table">@sortablelink('tipo_emissaos_id', 'Emissão')</th>
                <th class="w-1/4 color-header-table">INSCRIÇÃO MUNICIPAL</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($listaDeTomadores as $tomador)
                <tr>
                    <td class="p-3">
                        <input type="checkbox" class="select" value="{{ $tomador->id }}">
                    </td>
                    <td><a class="hover:underline"
                            href="{{ route('tomadores.edit', $tomador->id) }}">{{ $tomador->nome }}</a></td>
                    <td>{{ $tomador->cpf_cnpj }}</td>
                    <td>{{ $tomador->tipoEmissao?->nome ?? $tomador->nome_emissao }}</td>
                    <td>{{ $tomador->inscricao_municipal }}</td>

                </tr>
            @endforeach
        </x-slot>
    </x-table>
    {{ $listaDeTomadores->appends(Request::except('page'))->render() }}

</x-app-layout>
