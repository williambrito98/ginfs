<x-app-layout>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr>

    <x-datalist class="bg-table" :items="$permissions" :route="route('papeis.permissoes.store', $role->id)"
        placeholder="Permissões" />

    <x-user.container active="cargos">
        <x-table class="my-2">
            <x-slot name="columns">
                <tr class="bg-btn-dropdown-client">
                    <th class="w-1/4 p-3 color-header-table">PERMISSÃO</th>
                    <th class="w-1/4 color-header-table">DESCRIÇÃO</th>
                    <th class="w-1/4 color-header-table"></th>
                </tr>
            </x-slot>

            <x-slot name="content">
                @foreach ($role->permissions as $permission)
                    <tr>
                        <td class="p-3">{{ $permission->nome }}
                        </td>
                        <td>{{ $permission->descricao }}</td>
                        <td>
                            <form action="{{ route('papeis.permissoes.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                <input type="hidden" name="permission_id" value="{{ $permission->id }}">
                                <x-button type="icon">
                                    <x-svg.trash />
                                </x-button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
        </x-container>


</x-app-layout>
