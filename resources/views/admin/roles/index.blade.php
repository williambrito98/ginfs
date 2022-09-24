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
                    <th class="color-header-table showDelete py-2 pl-4">
                        <input type="checkbox" id="selectAll" class="rounded-sm">
                    </th>
                    <th class="w-3/12 color-header-table">CARGO</th>
                    <th class="w-6/12 color-header-table">DESCRIÇÃO</th>
                    <th class="w-3/12 color-header-table">PERMISSÕES</th>
                </tr>
            </x-slot>

            <x-slot name="content">
                @foreach ($roles as $role)
                    <tr class="border-top">
                        <td class="py-4 pl-4">
                            <input type="checkbox" class="select rounded-sm" value="{{ $role->id }}">
                        </td>
                        <td>
                            <a href="{{ route('papeis.edit', $role->id) }}"
                                class="hover:underline">{{ $role->nome }}</a>
                        </td>
                        <td>{{ $role->descricao }}</td>
                        <td class="transform hover:scale-105 motion-reduce:transform-none">
                            <x-button type="link" :url="route('papeis.permissoes', $role->id)"
                            class="bg-btn-yellow">
                                PERMISSÕES
                            </x-button>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
        </x-container>


</x-app-layout>
