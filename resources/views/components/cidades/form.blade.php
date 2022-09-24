@props(['message', 'cidade', 'action', 'method'])

<form action={{ $action }} method="POST" class="max-w-screen-md mx-auto">
    @csrf
    {{ $method ?? '' }}
    <div>
        <div>
            <x-form.label value="NOME" />
            <x-form.input type="text" name="nome" value="{{ $cidade->nome ?? old('nome') }}" required
                class="rounded w-full" />
        </div>
        <div>
            <x-form.label value="URL GINFES" />
            <x-form.input type="url" name="urlGinfes" value="{{ $cidade->url_ginfes ?? old('urlGinfes') }}" required
                class="rounded w-full" />
        </div>
    </div>
    <x-button type="submit">Salvar</x-button>
</form>
