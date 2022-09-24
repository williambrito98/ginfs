<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <x-clientes.container :clienteID="$cliente->id" active="clientes">
        <x-clientes.form :action="route('clientes.update', $cliente->id)" :cliente="$cliente">
            <x-slot name="method">
                @method('PATCH')
            </x-slot>
        </x-clientes.form>
    </x-clientes.container>
</x-app-layout>
