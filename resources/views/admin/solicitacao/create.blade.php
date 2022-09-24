<x-app-layout>   
    
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3"/>

    <x-container :tabs="[['url' => '', 'active' => '', 'title' => 'SOLICITAÇÃO DE EMISSÃO DE NOTA FISCAL']]">
        <form method="POST" action="{{ route('notafiscal.store') }}">
            @csrf
            <x-solicitacao.form />
            <x-button type="submit">Solicitar</x-button>
        </form>
    </x-container>

</x-app-layout>