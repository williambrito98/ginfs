@props(['tiposEmissao', 'tomador', 'route', 'method'])

<form action="{{ $route }}" method="POST" class="mt-10">
    @csrf
    {{ $method ?? '' }}
    <x-form.label value="CPF/CNPJ" for="cpf_cnpj" />
    <x-form.input id="cpf_cnpj" data-mask-for-cpf-cnpj type="text" name="cpf_cnpj" placeholder="CPF/CNPJ"
        value="{{ $tomador->cpf_cnpj ?? old('cpf_cnpj') }}" required autofocus class="w-full mt-2" />
    @error('cpf_cnpj')

    @enderror
    <x-form.label for="nome" :value="__('Nome')" />
    <x-form.input id="nome" class="w-full mt-2" type="text" name="nome" value="{{ $tomador->nome ?? old('nome') }}"
        required autofocus />
    <div class="flex items-center justify-between">
        <div class="flex-basis-45">
            <x-form.label for="inscricao_municipal" :value="__('Inscricao Municipal')" />
            <x-form.input id="inscricao_municipal" class="w-full mt-2" type="text" name="inscricao_municipal"
                value="{{ $tomador->inscricao_municipal ?? old('inscricao_municipal') }}" required autofocus />
        </div>
        <div class="flex-basis-45">
            <x-form.label for="tipo_emissao" :value="__('Emissão')" />
            <select class="w-full mt-2 border-yellow-400" id="tipo_emissao" name="tipo_emissao">

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
    <div class="w-full my-8 flex justify-end">
        <x-button type="submit"> {{ __('Salvar') }} </x-button>
    </div>
</form>
