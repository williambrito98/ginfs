<x-app-layout>
    <x-title title="Usuários" />
    <hr>
    @if(Gate::check('adicionar-usuarios') && Gate::check('deletar-usuarios'))
        <x-add-and-delete :routeAdd="route('usuarios.create')" :routeDelete="route('usuarios.destroy')" />
    @endif
    <x-user.container active="usuarios" class="rounded-xl">
        <x-table class="rounded-b-xl">
            <x-slot name="columns">
                <tr>
                    <th class="color-header-table showDelete py-2 pl-4">
                        <input type="checkbox" id="selectAll" class="rounded-sm">
                    </th>
                    <th class="w-2/6 color-header-table">NOME</th>
                    <th class="w-2/6 color-header-table">E-MAIL</th>
                    <th class="w-2/6 color-header-table">CARGO</th>
                </tr>
            </x-slot>

            <x-slot name="content">
                @foreach ($users as $user)
                    <tr class="border-top">
                        <td class="py-4 pl-4">
                            <input type="checkbox" class="select rounded-sm" value="{{ $user->id }}">
                        </td>
                        <td>
                            <a href="{{ route('usuarios.edit', $user->id) }}"
                                class="hover:underline">{{ $user->name }}</a>
                        </td>
                        <td>{{ $user?->email }}</td>
                        <td>{{ $user->roles[0]->nome ?? '' }}</td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
    </x-container>


</x-app-layout>
