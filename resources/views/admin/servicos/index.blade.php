<x-app-layout>
    <x-title title="Tipos de Serviços" />
    <hr>
    @can('adicionar-servicos')
        <x-add-register :route="route('servicos.create')" />
    @endcan
    @can('deletar-servicos')
        <x-delete-register :route="route('servicos.destroy')" />
    @endcan
    <x-table class="my-16">
        <x-slot name="columns">
            <tr class="bg-btn-dropdown-client">
                <th class="w-1/4 p-3 color-header-table showDelete">
                    <input type="checkbox" id="selectAll">
                </th>
                <th class="w-1/4 color-header-table">CÓDIGO</th>
                <th class="w-1/4 color-header-table">SERVIÇO</th>
                <th class="w-1/4 color-header-table">ISS</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($servicos as $servico)
                <tr>
                    <td class="p-3">
                        <input type="checkbox" class="select" value="{{ $servico->id }}">
                    </td>
                    <td><a class="hover:underline"
                            href="{{ route('servicos.edit', $servico->id) }}">{{ $servico->codigo }}</a></td>
                    <td>{{ $servico->nome }}</td>
                    <td>
                        @if ($servico->retencao_iss)
                            <div class="bg-red-E32626  inline p-2 rounded-lg">RETIDO</div>
                        @else
                            <div class="bg-green-56CA11 inline p-2 rounded-lg">NÃO RETIDO</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
</x-app-layout>
