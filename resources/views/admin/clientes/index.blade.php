<x-app-layout>
    <x-title title="Clientes" />
    <hr>

    @if(Gate::check('adicionar-usuarios') && Gate::check('deletar-usuarios'))
        <x-add-and-delete :routeAdd="route('clientes.create')" :routeDelete="route('clientes.destroy')" />
    @endif
    
    <x-table class="rounded-xl">
        <x-slot name="columns">
            <tr>
                <th class="color-header-table showDelete px-4 py-2">
                    <input type="checkbox" id="selectAll" class="rounded-sm">
                </th>
                <th class="w-2/6 color-header-table">CNPJ</th>
                <th class="w-2/6 color-header-table">RAZÃO SOCIAL</th>
                <th class="w-2/6 color-header-table">E-MAIL</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($clientes as $cliente)
                <tr class="border-top hover:bg-gray-300 cursor-pointer">
                    <td class="rounded-l-xl px-4 py-8">
                        <input type="checkbox" class="select rounded-sm" value="{{ $cliente->id }}">
                    </td>
                    <td onClick="document.location.href='{{ route('clientes.edit', $cliente->id) }}'">
                        {{ $cliente->cpf_cnpj }}
                    </td>
                    <td onClick="document.location.href='{{ route('clientes.edit', $cliente->id) }}'">
                        {{ $cliente->razao_social }}
                    </td>
                    <td class="rounded-r-xl" onClick="document.location.href='{{ route('clientes.edit', $cliente->id) }}'">
                        {{ $cliente->email }}
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
</x-app-layout>