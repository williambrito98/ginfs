<x-app-layout>
    <x-title title="Cidades" />
    <hr>

    @if(Gate::check('adicionar-cidades') && Gate::check('deletar-cidades'))
        <x-add-and-delete :routeAdd="route('cidades.create')" :routeDelete="route('cidades.destroy')" />
    @endif
    
    <x-table class="rounded-xl">
        <x-slot name="columns">
            <tr>
                <th class="color-header-table showDelete rounded-tl-xl pl-4 py-2">
                    <input type="checkbox" id="selectAll" class="rounded-sm">
                </th>
                <th class="w-2/4 color-header-table">CIDADE</th>
                <th class="w-2/4 color-header-table">URL GINFES</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($cidades as $cidade)
                <tr class="border-top">
                    <td class="pl-4 py-4">
                        <input type="checkbox" class="select rounded-sm" value="{{ $cidade->id }}">
                    </td>
                    <td><a class="hover:underline"
                            href="{{ route('cidades.edit', $cidade->id) }}">{{ $cidade->nome }}</a></td>
                    <td>{{ $cidade->url_ginfes }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
</x-app-layout>
