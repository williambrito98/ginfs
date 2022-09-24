<x-app-layout>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">
    
    <section class="container bg-table rounded-xl mx:auto">
        <div class="text-center bg-grey-darker py-2.5 rounded-t-xl">
            <h3 class="text-5C5C5C">TIPO DE SERVIÇO</h3>
        </div>
        <x-servicos.form :servico="$servico" :action="route('servicos.update', $servico->id)" >
            <x-slot name="method">
                @method('PATCH')
            </x-slot>
        </x-servicos.form>
    </section>

</x-app-layout>
