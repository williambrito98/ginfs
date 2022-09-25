<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr>

    <x-datalist placeholder="Buscar tipos de serviços" :route="route('clientes.tomadores.servicos.store')" :userID="$userID"
        :tomadorID="$tomadorID" :items="$servicos">
        <x-slot name="delete">
            <x-delete-register :route="route('clientes.tomadores.servico.destroy')" :userID="$userID"
                :tomadorID="$tomadorID" />
        </x-slot>
    </x-datalist>

    <x-clientes.container :clienteID="$id" :tomadorID="$id" active="tomadores">
        <div class="text-center bg-grey-darker py-2.5 my-2">
            <h3 class="text-5C5C5C">DETALHES DO TOMADOR</a>
        </div>
        <div class="max-w-screen-lg mx-auto">
            <x-form.label value="CPF/CNPJ" />
            <x-form.input type="text" name="cpf_cnpj" value="{{ $tomador->nome }}"
                class="w-full bg-grey-darker rounded" disabled />

            <x-form.label value="NOME" />
            <x-form.input type="text" name="nome" value="{{ $tomador->cpf_cnpj }}"
                class="w-full bg-grey-darker rounded" disabled />
        </div>

        <div class="max-w-screen-lg mx-auto pb-4">
            <div class="text-center bg-grey-light py-2.5 my-2">
                <h3 class="text-5C5C5C">TIPOS DE SERVIÇO</a>
            </div>

            <x-table class="rounded-b-xl">
                <x-slot name="columns">
                    <tr class="bg-grey-darker">
                        <th class="w-1/12 color-header-table showDelete py-2">
                            <input type="checkbox" id="selectAll" class="rounded-sm">
                        </th>
                        <th class="w-1/12 color-header-table">CÓDIGO</th>
                        <th class="w-8/12 color-header-table">ATIVIDADE</th>
                        <th class="w-3/12 color-header-table">ISS</th>
                    </tr>
                </x-slot>
                <x-slot name="content">
                    @foreach ($tomadorServicos as $tomadorServico)
                        <tr class="border-top">
                            <td class="py-4 rounded-bl-xl">
                                <input type="checkbox" class="select rounded-sm" value="{{ $tomadorServico->id }}">
                            </td>
                            <td>{{ $tomadorServico->codigo }}</td>
                            <td>{{ $tomadorServico->cod_atividade }}</td>
                            <td class="rounded-br-xl">
                                @if ($tomadorServico->retencao_iss)
                                    <div class="bg-red-E32626  inline py-1 px-3 rounded-full">retido</div>
                                @else
                                    <div class="bg-green-56CA11 inline py-1 px-3 rounded-full">não retido</div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        </div>
    </x-clientes.container>

</x-app-layout>
