<x-app-layout>
    <x-title title="Usuários" />
    <hr>
    @can('adicionar-usuarios')
        <x-add-register :route="route('usuarios.create')" />
    @endcan
    @can('deletar-usuarios')
        <x-delete-register :route="route('usuarios.destroy')" />
    @endcan
    <x-user.container active="usuarios" class="mt-16">
        <x-table class="my-2">
            <x-slot name="columns">
                <tr class="bg-btn-dropdown-client">
                    <th class="w-1/6 p-3 color-header-table showDelete">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th class="w-1/4 p-3 color-header-table">CARGO</th>
                    <th class="w-1/4 color-header-table">NOME</th>
                    <th class="w-1/4 color-header-table">E-MAIL</th>
                </tr>
            </x-slot>

            <x-slot name="content">
                @foreach ($users as $user)
                    <tr>
                        <td class="p-3">
                            <input type="checkbox" class="select" value="{{ $user->id }}">
                        </td>
                        <td>{{ $user->roles[0]->nome }}</td>
                        <td class="p-3">
                            <a href="{{ route('usuarios.edit', $user->id) }}"
                                class="hover:underline">{{ $user->name }}</a>
                        </td>
                        <td>{{ $user?->email }}</td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
    </x-container>


</x-app-layout>
