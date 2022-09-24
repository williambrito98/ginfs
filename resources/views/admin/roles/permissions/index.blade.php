<x-app-layout>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr>

    <x-datalist :items="$permissions" :route="route('papeis.permissoes.store', $role->id)"
    placeholder="Permissões" />
        
    <x-user.container active="cargos">
        <x-table class="rounded-b-xl">
            <x-slot name="columns">
                <tr>
                    <th class="w-1/4 color-header-table py-2">PERMISSÃO</th>
                    <th class="w-1/4 color-header-table">DESCRIÇÃO</th>
                    <th class="w-1/4 color-header-table">REMOVER</th>
                </tr>
            </x-slot>

            <x-slot name="content">
                @foreach ($role->permissions as $permission)
                    <tr class="border-top">
                        <td class="py-2">{{ $permission->nome }}
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
