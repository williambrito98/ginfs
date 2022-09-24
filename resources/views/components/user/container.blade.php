@props(['active'])
<section {{ $attributes->merge(['class' => 'container mx:auto']) }}>
    <div class="flex bg-grey-darker rounded-t-xl justify-around text-center align-center">
        <a href="{{ route('usuarios.index') }}"
        class="@if ($active != 'usuarios') bg-FCD34D @endif flex-basis-50 m-2 py-0.5 rounded text-5C5C5C">
        USUÁRIOS
        </a>
        <a href="{{ route('papeis.index') }}"
        class="@if ($active != 'cargos') bg-FCD34D @endif flex-basis-50 m-2 py-0.5 rounded text-5C5C5C">
        CARGOS
        </a>
    </div>
    {{ $slot ?? '' }}
</section>
