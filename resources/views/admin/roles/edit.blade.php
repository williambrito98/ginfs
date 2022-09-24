<x-app-layout>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <section class="container mx-auto bg-table rounded-xl">
        <div class="text-center bg-grey-darker py-2.5 rounded-t-xl">
            <h3 class="text-5C5C5C">DETALHES DO CARGO</a>
        </div>
        <div class="max-w-screen-md mx-auto">
            <form action="{{ route('papeis.update', $role->id) }}" method="POST" >
                @csrf
                @method('PUT')
                <x-form.label value="NOME" />
                <x-form.input type="text" name="nome" value="{{ $role->nome }}"
                    class="w-full rounded" />
                <x-form.label value="DESCRIÇÃO " />
                <x-form.input type="text" name="descricao" value="{{ $role->descricao }}"
                    class="w-full rounded" />
                <x-button type="submit">Salvar</x-button>
            </form>
        </div>
    </section>

</x-app-layout>

