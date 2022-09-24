<x-app-layout>
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <section class="container mx-auto bg-table rounded-xl">
        <div class="text-center bg-grey-darker py-2.5 rounded-t-xl">
            <h3 class="text-5C5C5C">DETALHES DO TOMADOR</a>
        </div>
        <x-Tomadores.tomadores-form :tomador='$tomador' :tiposEmissao='$tiposEmissao'
            :route="route('tomadores.update', $tomador->id)">
            <x-slot name="method">
                @method('PATCH')
            </x-slot>
        </x-Tomadores.tomadores-form>
    </section>

    <script src="{{ asset('js/jquery.mask.js') }}" defer></script>
    <script src="{{ asset('js/Tomadores/tomadores.js') }}" defer></script>

</x-app-layout>
