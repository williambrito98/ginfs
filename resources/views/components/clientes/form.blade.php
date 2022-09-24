@props(['type' => 'info', 'message', 'cliente', 'action', 'method', 'cidades', 'tiposEmissao'])

<form action={{ $action }} method="POST" class="max-w-screen-md mx-auto">
    @csrf
    {{ $method ?? '' }}
    <div>
        <div>
            <x-form.label value="NOME" />
            <x-form.input type="text" name="nome" value="{{ $cliente->name ?? old('nome') }}" class="w-full" />
        </div>
        <div>
            <x-form.label value="E-MAIL" />
            <x-form.input type="email" name="email" value="{{ $cliente->email ?? old('email') }}"
                class="w-full" />
        </div>
        <div class="flex items-center justify-between">
            <div class="flex-basis-45">
                <x-form.label value="CIDADE" /><br>
                <select name="cidade_id" id="cidades"
                    class="rounded border-input focus:border-yellow-400 focus:ring-yellow-200 w-full">
                    @if (!old('cidade_id') && !isset($cliente))
                        <option selected>Selecione a cidade</option>
                    @else
                        <option>Selecione a cidade</option>
                    @endif

                    @foreach ($cidades as $cidade)
                        @if (old('cidade_id') == $cidade->id)
                            <option selected value="{{ $cidade->id }}">{{ $cidade->nome }}</option>
                        @else
                            @if (isset($cliente))
                                @if ($cidade->id == $cliente->cidade_id)
                                    <option selected value="{{ $cidade->id }}">{{ $cidade->nome }}
                                    </option>
                                @else
                                    <option value="{{ $cidade->id }}">{{ $cidade->nome }}</option>
                                @endif
                            @else
                                <option value="{{ $cidade->id }}">{{ $cidade->nome }}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
                @error('cidade_id')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <div class="flex-basis-45">
                <x-form.label for="tipo_emissao" value="TIPO DE EMISSÃO" />
                <select class="rounded border-input focus:border-yellow-400 focus:ring-yellow-200 w-full"
                    id="tipo_emissao" name="tipo_emissao">

                    @if (isset($cliente)) {{-- Modo edicao --}}
                        @foreach ($tiposEmissao as $tipoEmissao)
                            @if ($cliente->tipo_emissaos_id == $tipoEmissao->id)
                                <option value="{{ $tipoEmissao->id }}" selected>
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
        <div>
            @if (!isset($cliente))
                <x-form.label value="SENHA" />
                <x-form.input type="password" name="password" value="{{ old('password') }}" class="w-full" />
            @endif
        </div>
    </div>
    <div>
        <x-form.label value="CPF/CNPJ" />
        <x-form.input type="text" name="cpf_cnpj" data-mask-for-cpf-cnpj value="{{ $cliente->cpf_cnpj ?? old('cpf_cnpj') }}"
            class="w-full" />
    </div>
    <div>
        <x-form.label value="RAZÃO SOCIAL" />
        <x-form.input type="text" name="razao_social" value="{{ $cliente->razao_social ?? old('razao_social') }}"
            class="w-full" />
    </div>
    <div>
        <x-form.label value="INSCRIÇÃO MUNICIPAL" />
        <x-form.input type="text" name="inscricao_municipal"
            value="{{ $cliente->inscricao_municipal ?? old('inscricao_municipal') }}" class="w-full" />
    </div>

    <div>
        <x-form.label value="USUÁRIO GINFES" />
        <x-form.input type="text" name="usuarioGinfs" data-mask-for-cpf-cnpj value="{{ $cliente->usuario_ginfs ?? old('usuario_ginfs') }}"
            class="w-full" />
    </div>

    <div>
        <x-form.label value="SENHA GINFES" />
        <x-form.input type="password" name="senhaGinfs" value="{{ $cliente->senha_ginfs ?? old('senha_ginfs') }}"
            class="w-full" />
    </div>
    <x-button type="submit">Salvar</x-button>
</form>
