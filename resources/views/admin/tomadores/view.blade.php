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
                    <a class="float-right p-2 my-8 rounded bg-blue-400"
                        href="{{ route('tomadores.create') }}">Adicionar</a>
                    <form class="form-inline" method="GET">
                        <div class="form-group mb-2">
                            <label for="filter" class="col-sm-2 col-form-label">Busca: </label>
                            <input type="text" class="form-control" id="filter" name="filter" placeholder="Nome, CPF/CNPJ, Inscrição Municipal" value="{{$filter}}">
                        </div>
                        <button type="submit" class="clear-both">Filtrar</button>
                    </form>
                    <table class="clear-both w-full text-center">
                        <thead>
                            <th>@sortablelink('nome', 'Empresa')</th>
                            <th>CPF/CNPJ</th>
                            <th>Inscrição Municipal</th>
                            <th>@sortablelink('created_at', 'Data de Cadastro')</th>
                            <th>@sortablelink('tipo_emissaos_id', 'Tipo de Emissão')</th>
                        </thead>
                        <tbody>
                            @foreach ($listaDeTomadores as $tomador)
                                <tr>
                                    <td><a class="underline" href="{{route('tomadores.edit', $tomador->id)}}"> {{ $tomador->nome }}</a></td>
                                    <td>{{ $tomador->cpf_cnpj }}</td>
                                    <td>{{ $tomador->inscricao_municipal }}</td>
                                    <td>{{ \Carbon\Carbon::parse($tomador->created_at)->format('d/m/Y')}}</td>                                    
                                    <td>{{ $tomador->tipoEmissao?->nome ?? $tomador->nome_emissao }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $listaDeTomadores->appends(Request::except('page'))->render() }}
            </div>
        </div>
    </div>
</x-app-layout>
