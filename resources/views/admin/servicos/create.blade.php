<x-app-layout>
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr>
    <section class="container mx:auto">
        <x-servicos.form :action="route('servicos.store')" />
    </section>

</x-app-layout>
