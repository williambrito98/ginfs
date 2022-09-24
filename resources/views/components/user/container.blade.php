@props(['active'])
<section {{ $attributes->merge(['class' => 'container mx:auto bg-table rounded-lg']) }}>
    <div class="flex bg-D1D5DB justify-around text-center align-center rounded-t-lg rounded-b-none">
        <div class="flex-basis-50 m-2 @if ($active != 'usuarios') bg-FCD34D @endif">
            <a href="{{ route('usuarios.index') }}" class="text-5C5C5C">USUÁRIOS</a>
        </div>
        <div class="@if ($active != 'cargos') bg-FCD34D @endif flex-basis-50 m-2">
            <a href="{{ route('papeis.index') }}" class="text-5C5C5C">CARGOS</a>
        </div>
    </div>
    {{ $slot ?? '' }}
</section>
