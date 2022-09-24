@props(['type' => 'info', 'message', 'role', 'action', 'method'])

<form action="{{ $action }}" method="POST" class="max-w-screen-md mx-auto" >
    @csrf
    {{ $method ?? '' }}

    <x-form.label value="NOME" />
    <x-form.input type="text" name="nome" value="{{ $role->nome ?? old('nome') }}"
        class="w-full" />
    <x-form.label value="DESCRIÇÃO " />
    <x-form.input type="text" name="descricao" value="{{ $role->descricao ?? old('descricao') }}"
        class="w-full" />
    <x-button type="submit">Salvar</x-button>
</form>