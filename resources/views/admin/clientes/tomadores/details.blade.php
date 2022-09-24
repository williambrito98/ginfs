<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr>
    <x-delete-register :route="route('clientes.tomadores.servico.destroy')" :tomadorID="$tomadorID" :userID="$userID" />
    <x-clientes.container :clienteID="$id" active="tomadores">
        <div class="my-2 p-3 text-center text-sm bg-D1D5DB">
            <h3>DETALHES DO TOMADOR</h3>
        </div>
        <div class="w-4/5 mx-auto my-2">
            <label for="" class="block my-2 text-5C5C5C ">CPF/CNPJ</label>
            <input type="text" class="w-full border-none bg-D1D5DB rounded" value="08192897126" disabled>
            <label for="" class="block mt-2 text-5C5C5C ">NOME</label>
            <input type="text" class="w-full border-none my-2 bg-D1D5DB rounded" value="08192897126" disabled>
        </div>
        <div class="my-2 p-3 text-center text-sm bg-D1D5DB">
            <h3>TIPO DE SERVIÇO</h3>
        </div>
        <x-datalist :route="route('clientes.tomadores.servicos.store')" :userID="$userID" :items="$servicos"
            :tomadorID="$tomadorID" />
        <x-table>
            <x-slot name="columns">
                <tr class="bg-btn-dropdown-client">
                    <th class="w-1/6 p-3 color-header-table showDelete">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th class="w-1/6 color-header-table">CÓDIGO</th>
                    <th class="w-1/6 color-header-table">ISS</th>
                </tr>
            </x-slot>
            <x-slot name="content">
                @foreach ($tomadorServicos as $tomadorServico)
                    <tr>
                        <td class="p-3">
                            <input type="checkbox" class="select" value="{{ $tomadorServico->id }}">
                        </td>
                        <td>{{ $tomadorServico->nome }}
                        </td>
                        <td>
                            @if ($tomadorServico->retencao_iss)
                                <div class="bg-red-E32626  inline p-2 rounded-lg">RETIDO</div>
                            @else
                                <div class="bg-green-56CA11 inline p-2 rounded-lg">NÃO RETIDO</div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
    </x-clientes.container>

</x-app-layout>
