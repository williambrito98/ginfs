<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <section class="container bg-table rounded-xl mx:auto">
        <div class="text-center bg-grey-darker py-2.5 rounded-t-xl">
            <h3 class="text-5C5C5C">DETALHES DA CIDADE</a>
        </div>
        <x-cidades.form :action="route('cidades.update', $cidade->id)" :cidade="$cidade">
            <x-slot name="method">
                @method('PATCH')
            </x-slot>
        </x-cidades.form>
    </section>
</x-app-layout>
