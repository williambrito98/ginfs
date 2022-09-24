@props(['tiposEmissao', 'tomador', 'route', 'method'])

<form action="{{ $route }}" method="POST" class="max-w-screen-md mx-auto">
    @csrf
    {{ $method ?? '' }}
    <x-form.label value="CPF/CNPJ" for="cpf_cnpj" />
    <x-form.input id="cpf_cnpj" data-mask-for-cpf-cnpj type="text" name="cpf_cnpj"
        value="{{ $tomador->cpf_cnpj ?? old('cpf_cnpj') }}" required autofocus class="w-full" />
    @error('cpf_cnpj')

    @enderror
    <x-form.label for="nome" value="NOME" />
    <x-form.input id="nome" class="w-full" type="text" name="nome" value="{{ $tomador->nome ?? old('nome') }}"
        required autofocus />
    <div class="flex items-center justify-between">
        <div class="flex-basis-45">
            <x-form.label for="inscricao_municipal" value="INSCRIÇÃO MUNICIPAL" />
            <x-form.input id="inscricao_municipal" class="w-full" type="text" name="inscricao_municipal"
                value="{{ $tomador->inscricao_municipal ?? old('inscricao_municipal') }}" autofocus />
        </div>
        <div class="flex-basis-45">
            <x-form.label for="tipo_emissao" value="TIPO DE EMISSÃO" />
            <select class="rounded border-input focus:border-yellow-400 focus:ring-yellow-200 w-full" id="tipo_emissao" name="tipo_emissao">

                @if (isset($tomador)) {{-- Modo edicao --}}
                    @foreach ($tiposEmissao as $tipoEmissao)
                        @if ($tomador->tipo_emissaos_id == $tipoEmissao->id)
                            <option value="{{ $tipoEmissao->id }}" selected}} selected>
                                {{ $tipoEmissao->nome }}</option>
                        @else
                            <option value="{{ $tipoEmissao->id }}">{{ $tipoEmissao->nome }}</option>
                        @endif
                    @endforeach
                @else
                    @if ($tiposEmissao->count())
                        @foreach ($tiposEmissao as $tipoEmissao)
                            @if (old('tipo_emissao') == $tipoEmissao->id)
                                <option value="{{ $tipoEmissao->id }}"
                                    {{ $tipoEmissao->tipo_emissaos_id == $tipoEmissao->id ? 'selected' : '' }}
                                    selected>{{ $tipoEmissao->nome }}</option>
                            @else
                                <option value="{{ $tipoEmissao->id }}">{{ $tipoEmissao->nome }}</option>
                            @endif
                        @endforeach
                    @endif
                @endif

            </select>
        </div>
    </div>
    <x-button type="submit">Salvar</x-button>
</form>
