<x-app-layout>
    <x-title title="Usuários" />
    <hr>
    @can('adicionar-usuarios')
        <x-add-register :route="route('papeis.create')" />
    @endcan
    @can('deletar-usuarios')
        <x-delete-register :route="route('papeis.destroy')" />
    @endcan
    <x-user.container active="cargos" class="mt-16">
        <x-table class="my-2">
            <x-slot name="columns">
                <tr class="bg-btn-dropdown-client">
                    <th class="w-1/6 p-3 color-header-table showDelete">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th class="w-1/4 p-3 color-header-table">CARGO</th>
                    <th class="w-1/4 color-header-table">DESCRIÇÃO</th>
                    <th class="w-1/4 color-header-table"></th>
                </tr>
            </x-slot>

            <x-slot name="content">
                @foreach ($roles as $role)
                    <tr>
                        <td class="p-3">
                            <input type="checkbox" class="select" value="{{ $role->id }}">
                        </td>
                        <td class="p-3">
                            <a href="{{ route('papeis.edit', $role->id) }}"
                                class="hover:underline">{{ $role->nome }}</a>
                        </td>
                        <td>{{ $role->descricao }}</td>
                        <td><x-button type="link" class="bg-btn-yellow" :url="route('papeis.permissoes', $role->id)">PERMISSÕES</x-button></td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
        </x-container>


</x-app-layout>
