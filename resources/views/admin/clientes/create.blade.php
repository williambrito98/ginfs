<x-app-layout>
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <x-clientes.container active="clientes">
        <x-clientes.form :action="route('clientes.store')" :cidades="$cidades" :tiposEmissao="$tiposEmissao" />
    </x-clientes.container>

    <script src="{{ asset('js/jquery.mask.js') }}" defer></script>
    <script src="{{ asset('js/Tomadores/tomadores.js') }}" defer></script>
</x-app-layout>
