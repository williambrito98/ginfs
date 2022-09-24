<x-app-layout>
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <x-clientes.container :clienteID="$cliente->id" active="clientes">
        <x-clientes.form :action="route('clientes.update', $cliente->id)" :cliente="$cliente" :cidades="$cidades" :tiposEmissao="$tiposEmissao">
            <x-slot name="method">
                @method('PATCH')
            </x-slot>
        </x-clientes.form>
    </x-clientes.container>

    <script src="{{ asset('js/jquery.mask.js') }}" defer></script>
    <script src="{{ asset('js/Tomadores/tomadores.js') }}" defer></script>

</x-app-layout>
