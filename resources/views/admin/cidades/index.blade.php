<x-app-layout>
    <x-title title="Cidades" />
    <hr>

    @if(Gate::check('adicionar-cidades') && Gate::check('deletar-cidades'))
        <x-add-and-delete :routeAdd="route('cidades.create')" :routeDelete="route('cidades.destroy')" />
    @endif
    
    <x-table class="rounded-xl">
        <x-slot name="columns">
            <tr>
                <th class="color-header-table showDelete rounded-tl-xl px-4 py-2">
                    <input type="checkbox" id="selectAll" class="rounded-sm">
                </th>
                <th class="w-2/4 color-header-table">CIDADE</th>
                <th class="w-2/4 color-header-table">URL GINFES</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($cidades as $cidade)
                <tr class="border-top hover:bg-gray-300 cursor-pointer">
                    <td class="rounded-l-xl px-4 py-4">
                        <input type="checkbox" class="select rounded-sm" value="{{ $cidade->id }}">
                    </td>
                    <td onClick="document.location.href='{{ route('cidades.edit', $cidade->id) }}'">
                        {{ $cidade->nome }}
                    </td>
                    <td class="rounded-r-xl" onClick="document.location.href='{{ route('cidades.edit', $cidade->id) }}'">
                        {{ $cidade->url_ginfes }}
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
</x-app-layout>
