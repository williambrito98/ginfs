<x-app-layout>
    <x-title title="Clientes" />
    <hr>

    @if(Gate::check('adicionar-usuarios') && Gate::check('deletar-usuarios'))
        <x-add-and-delete :routeAdd="route('clientes.create')" :routeDelete="route('clientes.destroy')" />
    @endif
    
    <x-table class="rounded-xl">
        <x-slot name="columns">
            <tr>
                <th class="color-header-table showDelete pl-4 py-2">
                    <input type="checkbox" id="selectAll" class="rounded-sm">
                </th>
                <th class="w-2/6 color-header-table">CNPJ</th>
                <th class="w-2/6 color-header-table">RAZÃO SOCIAL</th>
                <th class="w-2/6 color-header-table">E-MAIL</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($clientes as $cliente)
                <tr class="border-top">
                    <td class="pl-4 py-8">
                        <input type="checkbox" class="select rounded-sm" value="{{ $cliente->id }}">
                    </td>
                    <td>{{ $cliente->cpf_cnpj }}</td>
                    <td>
                        <a class="hover:underline"
                            href="{{ route('clientes.edit', $cliente->id) }}">
                            {{ $cliente->razao_social }}
                        </a>
                    </td>
                    <td>{{ $cliente->email }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
</x-app-layout>