<x-app-layout>
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr>
    <section class="container mx:auto">
        <x-servicos.form :servico="$servico" :action="route('servicos.update', $servico->id)">
            <x-slot name="method">
                @method('PATCH')
            </x-slot>
        </x-servicos.form>
    </section>

</x-app-layout>
