<x-app-layout>
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr>
    <x-container :tabs="[['url' => '', 'active' => '', 'title' => 'TOMADOR']]">
        <x-Tomadores.tomadores-form :tomador='$tomador' :tiposEmissao='$tiposEmissao'
            :route="route('tomadores.update', $tomador->id)">
            <x-slot name="method">
                @method('PATCH')
            </x-slot>
        </x-Tomadores.tomadores-form>
    </x-container>

    <script src="{{ asset('js/jquery.mask.js') }}" defer></script>
    <script src="{{ asset('js/Tomadores/tomadores.js') }}" defer></script>

</x-app-layout>
