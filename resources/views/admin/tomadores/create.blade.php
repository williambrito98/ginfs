<x-app-layout>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <section class="container bg-table rounded-xl mx:auto">
        <div class="text-center bg-grey-darker py-2.5 rounded-t-xl">
            <h3 class="text-5C5C5C">DETALHES DO TOMADOR</h3>
        </div>
        <x-Tomadores.tomadores-form :tiposEmissao='$tiposEmissao' :route="route('tomadores.store')" />
    </section>

    <script src="{{ asset('js/jquery.mask.js') }}" defer></script>
    <script src="{{ asset('js/Tomadores/tomadores.js') }}" defer></script>

</x-app-layout>
