<x-app-layout>
    <x-title title="Tipos de Serviço" />
    <hr>

    @if(Gate::check('adicionar-servicos') && Gate::check('deletar-servicos'))
        <x-add-and-delete :routeAdd="route('servicos.create')" :routeDelete="route('servicos.destroy')" />
    @endif

    <x-table class="rounded-xl">
        <x-slot name="columns">
            <tr>
                <th class="color-header-table showDelete py-2 px-4">
                    <input type="checkbox" id="selectAll" class="rounded-sm">
                </th>
                <th class="w-2/6 color-header-table">CÓDIGO</th>
                <th class="w-2/6 color-header-table">ATIVIDADE</th>
                <th class="w-2/6 color-header-table">ISS</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($servicos as $servico)
                <tr class="border-top hover:bg-gray-300 cursor-pointer">
                    <td class="rounded-l-xl px-4 py-4">
                        <input type="checkbox" class="select rounded-sm" value="{{ $servico->id }}">
                    </td>
                    <td onClick="document.location.href='{{ route('servicos.edit', $servico->id) }}'">
                        {{ $servico->codigo }}
                    </td>
                    <td onClick="document.location.href='{{ route('servicos.edit', $servico->id) }}'">
                        {{ $servico->cod_atividade }}
                    </td>
                    <td class="rounded-r-xl" onClick="document.location.href='{{ route('servicos.edit', $servico->id) }}'">
                        @if ($servico->retencao_iss)
                            <div class="bg-red-E32626  inline py-1 px-3 rounded-full">retido</div>
                        @else
                            <div class="bg-green-56CA11 inline py-1 px-3 rounded-full">não retido</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
</x-app-layout>
