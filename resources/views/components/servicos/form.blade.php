@props(['type' => 'info', 'message', 'servico', 'action', 'method'])


<form action="{{ $action }}" method="POST" class="border mt-10 rounded-lg bg-form">
    @csrf
    {{ $method ?? '' }}
    <div class="bg-gray-400 bg-btn-dropdown-client py-2 rounded-t-md">
        <h3 class="text-center color-header-table">SERVIÇO</h3>
    </div>
    <div class="pt-10 px-20">
        <div class="grid grid-cols-6 items-center">
            <label for="name"
                class="mr-5 color-header-table @error('codigo') border-red-600 border-2 @enderror">CÓDIGO</label>
            <input type="text" id="name" value="{{ $servico->codigo ?? old('codigo') }}" name="codigo"
                class="text-sm w-full bg-white py-2 px-5 rounded-lg col-start-2 col-end-7">
            @error('codigo')
                <p>{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="pt-4 px-20">
        <div class="grid grid-cols-6 items-center">
            <label for="descricao" class="mr-5 color-header-table">DESCRIÇÃO</label>
            <textarea id="descricao" name="nome"
                class="p-1 text-sm bg-white rounded-lg col-start-2 col-end-7 @error('nome') border-red-600 border-2 @enderror"
                cols="500" rows="5" style="resize: none;">
                {{ $servico->nome ?? (old('nome') ?? '') }}
        </textarea>
            @error('nome')
                <p>{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="py-4 px-20">
        <div class="grid grid-cols-6 items-center">
        <label for="codAtividade"
                class="mr-5 color-header-table @error('codAtividade') border-red-600 border-2 @enderror">CÓDIGO DA ATIVIDADE:</label>
            <input type="text" id="cod-atividade" value="{{ $servico->cod_atividade ?? old('codAtividade') }}" name="codAtividade"
                class="text-sm w-full bg-white py-2 px-5 rounded-lg col-start-2 col-end-7">
            @error('codAtividade')
                <p>{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="py-4 px-20">
        <div class="grid grid-cols-6 items-center">
            <label for="retencao_iss" class="mr-5 color-header-table">Retido ISS: </label>
            <input type="checkbox" id="retencao_iss" name="retencao_iss" @if (old('retencao_iss') || isset($servico->retencao_iss)) checked="checked"  @endif>
        </div>
    </div>
    <div class="pt-4 px-20">
        <button type="submit"
            class="block mb-4 md:ml-auto lg:ml-auto xl:ml-auto bg-btn-yellow px-10 py-1 rounded hover:bg-yellow-600">Salvar</button>
    </div>
</form>
