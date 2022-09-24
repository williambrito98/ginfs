<x-app-layout>   

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitação') }}
        </h2>
    </x-slot>
    
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />

    <hr/>

    <x-container :tabs="[['url' => '', 'active' => '', 'title' => 'SOLICITAÇÃO DE EMISSÃO DE NOTA FISCAL']]">
        <form method="POST" action="{{ route('notafiscal.store') }}">
            @csrf
            <x-solicitacao.form />
            <button type="submit" class="float-right mt-4 bg-btn-yellow px-10 py-1 rounded hover:bg-yellow-600">Solicitar</button>
            <br/>
            <br/>
            <br/>
        </form>
    </x-container>
</x-app-layout>

