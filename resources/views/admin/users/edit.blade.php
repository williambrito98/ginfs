<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuários') }}
        </h2>
    </x-slot>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <section class="container mx-auto bg-table rounded-xl">
        <div class="text-center bg-grey-darker py-2.5 rounded-t-xl">
            <h3 class="text-5C5C5C">DETALHES DO USUÁRIO</a>
        </div>
        <x-user.form :user="$user" :roles="$roles" :action="route('usuarios.update', $user->id)">
            <x-slot name="method">
                @method('PATCH')
            </x-slot>
        </x-user.form>

    </section>
</x-app-layout>
