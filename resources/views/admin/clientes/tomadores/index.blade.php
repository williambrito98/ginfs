<x-app-layout>
    
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr>
    
    <x-datalist placeholder="Busca" :route="route('clientes.tomadores.store')" :userID="$userID" :items="$tomadores">
        <x-slot name="delete">
            <x-delete-register :route="route('clientes.tomadores.destroy')" :userID="$userID" />
        </x-slot>                
    </x-datalist>

    <x-clientes.container :clienteID="$id" active="tomadores">
        <x-table class="rounded-xl my-1">
            <x-slot name="columns">
                <tr>
                    <th class="color-header-table showDelete pl-4 py-2">
                        <input type="checkbox" id="selectAll" class="rounded-sm">
                    </th>
                    <th class="w-3/6 color-header-table">CNPJ</th>
                    <th class="w-3/6 color-header-table">RAZÃO SOCIAL</th>
                </tr>
            </x-slot>
            <x-slot name="content">
                @foreach ($clienteTomadores as $clienteTomador)
                    <tr class="border-top">
                        <td class="py-4">
                            <input type="checkbox" class="select rounded-sm" value="{{ $clienteTomador->id }}">
                        </td>
                        <td>{{ $clienteTomador->cpf_cnpj }}</td>
                        <td>
                            <a class="hover:underline" href="{{ route('clientes.tomador.details', [$id, $clienteTomador->id]) }}">
                            {{ $clienteTomador->nome }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
    </x-clientes.container>


</x-app-layout>
