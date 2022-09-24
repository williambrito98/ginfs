@props(['clienteID', 'active'])
<section class="container mx:auto bg-table rounded-lg">
    <div class="flex bg-grey-darker justify-around text-center align-center">
            <a href="@if (isset($clienteID)) {{ route('clientes.edit', $clienteID) }} @else {{ route('clientes.create') }}  @endif"
            class="@if ($active != 'clientes') bg-FCD34D @endif flex-basis-33 m-2 py-0.5 text-5C5C5C rounded">
                CLIENTES
            </a>
        @if (isset($clienteID))
            <a href="@if (isset($clienteID)) {{ route('clientes.faturamento.index', $clienteID) }} @endif"
            class="@if ($active != 'faturamento') bg-FCD34D @endif flex-basis-33 m-2 py-0.5 text-5C5C5C rounded">
                FATURAMENTO
            </a>
            <a href="{{ route('clientes.tomadores.index', $clienteID) }}"
            class="@if ($active != 'tomadores') bg-FCD34D @endif flex-basis-33 m-2 py-0.5 text-5C5C5C rounded">
                TOMADORES
            </a>
        @endif
    </div>
    {{ $slot ?? '' }}
</section>
