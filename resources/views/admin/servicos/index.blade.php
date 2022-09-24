<x-app-layout>
    <x-title title="Tipos de Serviço" />
    <hr>

    @if(Gate::check('adicionar-servicos') && Gate::check('deletar-servicos'))
        <x-add-and-delete :routeAdd="route('servicos.create')" :routeDelete="route('servicos.destroy')" />
    @endif

    <x-table class="rounded-xl">
        <x-slot name="columns">
            <tr>
                <th class="color-header-table showDelete py-2 pl-4">
                    <input type="checkbox" id="selectAll" class="rounded-sm">
                </th>
                <th class="w-3/12 color-header-table">CÓDIGO</th>
                <th class="w-6/12 color-header-table">DESCRIÇÃO</th>
                <th class="w-3/12 color-header-table">ISS</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($servicos as $servico)
                <tr class="border-top">
                    <td class="py-10 pl-4">
                        <input type="checkbox" class="select rounded-sm" value="{{ $servico->id }}">
                    </td>
                    <td>
                        <a class="hover:underline" href="{{ route('servicos.edit', $servico->id) }}">
                            {{ $servico->codigo }}
                        </a>
                    <td>{{ $servico->nome }}</td>
                    <td>
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
