<x-app-layout>
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr>
    <x-container :tabs="[['url' => '', 'active' => '', 'title' => 'TOMADOR']]">
        <x-Tomadores.tomadores-form :tiposEmissao='$tiposEmissao' :route="route('tomadores.store')" />
    </x-container>

    <script src="{{ asset('js/jquery.mask.js') }}" defer></script>
    <script src="{{ asset('js/Tomadores/tomadores.js') }}" defer></script>

</x-app-layout>
