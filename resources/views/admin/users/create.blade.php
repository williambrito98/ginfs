<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    
    <hr />

    <section class="container mx-auto bg-table mt-16 rounded-lg">
        <div class="text-center bg-D1D5DB rounded-t-lg py-1 rounded-b-none">
            <h3 class="text-5C5C5C">Novo Usuário</a>
        </div>
        <x-user.form :roles="$roles" :action="route('usuarios.store')" />
    </section>
</x-app-layout>
