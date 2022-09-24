@props(['type' => 'info', 'message', 'servico', 'action', 'method'])

<form action="{{ $action }}" method="POST" class="max-w-screen-md mx-auto">
    @csrf
    {{ $method ?? '' }}
    <div>
        <div class="flex items-center justify-between">
            <div class="flex-basis-45">
                <x-form.label value="CÓDIGO" />
                <x-form.input type="text" id="name" value="{{ $servico->codigo ?? old('codigo') }}" name="codigo"
                    class="w-full" />
            </div>
            <div class="flex-basis-45">
                <x-form.label value="CÓDIGO DA ATIVIDADE" />
                <x-form.input type="text" id="cod-atividade" value="{{ $servico->cod_atividade ?? old('cod_atividade') }}" name="cod_atividade"
                class="w-full" />
            </div>
        </div>
        <div>
            <x-form.label value="DESCRIÇÃO" />
            <textarea id="descricao" name="nome"
                class="w-full border-input border-white rounded focus:border-yellow-400 focus:ring-yellow-200" cols="500" rows="5" style="resize: none;">
                {{ $servico->nome ?? (old('nome') ?? '') }}
            </textarea>
        </div>
        <div class="mt-4 mb-2">
            <label for="retencao_iss" class="mr-5 color-header-table">Retido ISS: </label>
            <input type="checkbox" id="retencao_iss" class="rounded-sm" name="retencao_iss" @if (old('retencao_iss') === true || (isset($servico) && $servico->retencao_iss === true)) checked="checked"  @endif>
        </div>
        <x-button type="submit">Salvar</x-button>
    </div>
</form>
