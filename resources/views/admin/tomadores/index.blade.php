<x-app-layout>
    <x-title title="Tomadores" />
    <hr>

    @if(Gate::check('adicionar-usuarios') && Gate::check('deletar-usuarios'))
    <x-add-and-delete :routeAdd="route('tomadores.create')" :routeDelete="route('tomadores.destroy')" />
    @endif

    <x-table class="rounded-xl">
        <x-slot name="columns">
            <tr>
                <th class="color-header-table showDelete px-4 py-2">
                    <input type="checkbox" id="selectAll" class="rounded-sm">
                </th>
                <th class="w-2/6 color-header-table">CNPJ</th>
                <th class="w-2/6 color-header-table">RAZÃO SOCIAL</th>
                <th class="w-2/6 color-header-table">EMISSÃO</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($listaDeTomadores as $tomador)
                <tr class="border-top hover:bg-gray-300 cursor-pointer">
                    <td class="rounded-l-xl px-4 py-8">
                        <input type="checkbox" class="select rounded-sm" value="{{ $tomador->id }}">
                    </td>
                    <td onClick="document.location.href='{{ route('tomadores.edit', $tomador->id) }}'">
                        {{ $tomador->cpf_cnpj }}
                    </td>
                    <td onClick="document.location.href='{{ route('tomadores.edit', $tomador->id) }}'">
                        {{ $tomador->nome }}
                    </td>
                    <td class="rounded-r-xl" onClick="document.location.href='{{ route('tomadores.edit', $tomador->id) }}'">
                        {{ $tomador->tipoEmissao?->nome ?? $tomador->nome_emissao }}
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
    <div class="pt-4">
        {{ $listaDeTomadores->links()  }}
    </div>


</x-app-layout>