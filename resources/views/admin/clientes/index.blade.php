<x-app-layout>
    <x-title title="Clientes" />
    <hr>
    @if(Gate::check('adicionar-usuarios') && Gate::check('deletar-usuarios'))
        <x-add-and-delete :routeAdd="route('clientes.create')" :routeDelete="route('clientes.destroy')" />
    @endif

    <div class="bg-grey-darker text-center text-lg mt-3.5 py-2">
        <p>CLIENTES</p>
    </div>

    <x-table class="mb-4">
        <x-slot name="columns">
            <tr class="border-b border-black">
                <th class="w-1/12 p-3 color-header-table showDelete">
                    <input type="checkbox" id="selectAll">
                </th>
                <th class="w-3/12 color-header-table">NOME</th>
                <th class="w-3/12 color-header-table">E-MAIL</th>
                <th class="w-3/12 color-header-table">CNPJ</th>
                <th class="w-3/12 color-header-table">INSCRIÇÃO MUNICIPAL</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($clientes as $cliente)
                <tr class="border-b border-black">
                    <td class="p-3">
                        <input type="checkbox" class="select" value="{{ $cliente->id }}">
                    </td>
                    <td><a class="hover:underline"
                            href="{{ route('clientes.edit', $cliente->id) }}">{{ $cliente->name }}</a></td>
                    <td>{{ $cliente->email }}</td>
                    <td>
                        {{ $cliente->cpf_cnpj }}
                    </td>
                    <td>
                        {{ $cliente->inscricao_municipal }}
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
</x-app-layout>
