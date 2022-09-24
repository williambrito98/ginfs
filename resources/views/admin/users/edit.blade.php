<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuários') }}
        </h2>
    </x-slot>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />

    <section class="container mx-auto bg-table mt-16 rounded-lg">
        <div class="text-center bg-D1D5DB rounded-t-lg py-1 rounded-b-none">
            <h3 class="text-5C5C5C">Editar Usuário</a>
        </div>
        <x-user.form :user="$user" :roles="$roles" :action="route('usuarios.update', $user->id)">
            <x-slot name="method">
                @method('PATCH')
            </x-slot>
        </x-user.form>

    </section>
</x-app-layout>
