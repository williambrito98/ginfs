<x-app-layout>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <section class="container mx-auto bg-table rounded-xl">
        <div class="text-center bg-grey-darker py-2.5 rounded-t-xl">
            <h3 class="text-5C5C5C">DETALHES DO CARGO</a>
        </div>
        <x-papeis.form :action="route('papeis.store')" />
    </section>

</x-app-layout>
