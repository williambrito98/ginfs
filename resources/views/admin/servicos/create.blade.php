<x-app-layout>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <section class="container bg-table rounded-xl mx:auto">
        <div class="text-center bg-grey-darker py-2.5 rounded-t-xl">
            <h3 class="text-5C5C5C">DETALHES DO TIPO DE SERVIÇO</h3>
        </div>
        <x-servicos.form :action="route('servicos.store')" />
    </section>

</x-app-layout>
