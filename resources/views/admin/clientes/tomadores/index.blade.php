<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr>
    
    <x-datalist placeholder="Busca" :route="route('clientes.tomadores.store')" :userID="$userID" :items="$tomadores">
        <x-slot name="delete">
            <x-delete-register :route="route('clientes.tomadores.destroy')" :userID="$userID" />
        </x-slot>                
    </x-datalist>

    <x-clientes.container-retangle :clienteID="$id" active="tomadores">
        <x-table>
            <x-slot name="columns">
                <tr class="bg-white border-b border-black">
                    <th class="w-1/12 p-3 color-header-table showDelete">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th class="w-7/12 color-header-table">RAZÃO SOCIAL</th>
                    <th class="w-2/12 color-header-table">CNPJ</th>
                </tr>
            </x-slot>
            <x-slot name="content">
                @foreach ($clienteTomadores as $clienteTomador)
                    <tr class="bg-white border-b border-black">
                        <td class="p-3">
                            <input type="checkbox" class="select" value="{{ $clienteTomador->id }}">
                        </td>
                        <td><a class="hover:underline"
                                href="{{ route('clientes.tomador.details', [$id, $clienteTomador->id]) }}">{{ $clienteTomador->nome }}</a>
                        </td>
                        <td>{{ $clienteTomador->cpf_cnpj }}</td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
    </x-clientes.container>


</x-app-layout>
