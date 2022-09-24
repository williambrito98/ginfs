@props(['type' => 'info', 'message', 'cliente', 'action', 'method'])

<form action={{ $action }} method="POST" class="max-w-screen-md mx-auto">
    @csrf
    {{ $method ?? '' }}
    <div>
        <div>
            <x-form.label value="NOME" />
            <x-form.input type="text" name="nome" value="{{ $cliente->name ?? old('nome') }}"
            class="w-full" />
        </div>
        <div>
            <x-form.label value="E-MAIL" />
            <x-form.input type="email" name="email" value="{{ $cliente->email ?? old('email') }}"
            class="w-full" />
        </div>
        <div>
            @if (!isset($cliente))
                <x-form.label value="SENHA" />
                <x-form.input type="password" name="password" value="{{ old('password') }}"
                class="w-full" />
            @endif
        </div>
    </div>
    <div>
        <x-form.label value="CPF/CNPJ" />
        <x-form.input type="text" name="cpf_cnpj"
        value="{{ $cliente->cpf_cnpj ?? old('cpf_cnpj') }}"
        class="w-full" />
    </div>
    <div>
        <x-form.label value="RAZÃO SOCIAL" />
        <x-form.input type="text" name="razao_social" value="{{ $cliente->razao_social ?? old('razao_social') }}"
        class="w-full" />
    </div>
    <div>
        <x-form.label value="INSCRIÇÃO MUNICIAPL" />
        <x-form.input type="text" name="inscricao_municipal" value="{{ $cliente->inscricao_municipal ?? old('inscricao_municipal') }}"
        class="w-full" />
    </div>

    <div>
        <x-form.label value="USUÁRIO GINFES" />
        <x-form.input type="text" name="usuarioGinfs" value="{{ $cliente->usuario_ginfs ?? old('usuario_ginfs') }}"
        class="w-full" />
    </div>
    
    <div>
        <x-form.label value="SENHA GINFES" />
        <x-form.input type="password" name="senhaGinfs" value="{{ old('senha_ginfs') }}"
        class="w-full" />
    </div>
    <x-button type="submit" >Salvar</x-button>
</form>
