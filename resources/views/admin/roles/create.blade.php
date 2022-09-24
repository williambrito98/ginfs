<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('papeis.store') }}" method="POST">
                        @csrf
                        <input type="text" name="nome" placeholder="Nome"
                            class="@error('nome') border-red-600 border-2 @enderror">
                        @error('nome')
                            <p>{{ $message }}</p>
                        @enderror
                        <input type="text" name="descricao" placeholder="Descrição"
                            class="@error('descricao') border-red-600 border-2 @enderror">
                        @error('descricao')
                            <p>{{ $message }}</p>
                        @enderror
                        <button type="submit">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
