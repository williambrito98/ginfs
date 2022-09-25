<x-app-layout>
    <x-title title="Cargos" />
    <hr>
    @if(Gate::check('adicionar-cargos') && Gate::check('deletar-cargos'))
        <x-add-and-delete :routeAdd="route('papeis.create')" :routeDelete="route('papeis.destroy')" />
    @endif
    <x-user.container active="cargos">
        <x-table class="rounded-b-xl">
            <x-slot name="columns">
                <tr>
                    <th class="color-header-table showDelete px-4">
                        <input type="checkbox" id="selectAll" class="rounded-sm">
                    </th>
                    <th class="w-3/12 color-header-table">CARGO</th>
                    <th class="w-6/12 color-header-table">DESCRIÇÃO</th>
                    <th class="w-3/12 color-header-table">PERMISSÕES</th>
                </tr>
            </x-slot>

            <x-slot name="content">
                @foreach ($roles as $role)
                    <tr class="border-top hover:bg-gray-300 cursor-pointer">
                        <td class="rounded-l-xl px-4 py-4">
                            <input type="checkbox" class="select rounded-sm" value="{{ $role->id }}">
                        </td>
                        <td onClick="document.location.href='{{ route('papeis.edit', $role->id) }}'">
                            {{ $role->nome }}
                        </td>
                        <td onClick="document.location.href='{{ route('papeis.edit', $role->id) }}'">
                            {{ $role->descricao }}
                        </td>
                        <td class="rounded-r-xl">
                            <x-button type="link" :url="route('papeis.permissoes', $role->id)"
                            class="bg-btn-yellow transform hover:scale-105 motion-reduce:transform-none">
                                PERMISSÕES
                            </x-button>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
        </x-container>


</x-app-layout>
