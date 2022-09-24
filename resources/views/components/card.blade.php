@props(['nomeCliente', 'razaoSocial', 'aliquota', 'valor', 'statusProcessamento', 'dataEmissao'])

<div class="rounded-lg overflow-hidden shadow-lg bg-grey w-80 mx-auto">
    <div class="bg-grey-darker p-3">
        <div class="mb-2 color-text-grey">PRESTADOR</div>
        <div class="text-md mx-4">{{$nomeCliente}}</div>
    </div>
    <div class="bg-grey p-3 border-b-2 border-gray-300">
        <div class="mb-2 color-text-grey">TOMADOR</div>
        <div class="text-md mx-4">{{$razaoSocial}}</div>
    </div>
    
    <div class="flex justify-between items-center p-4 border-b-2 border-gray-300">
        <div class="color-text-grey">ALÍQUOTA</div>
        <div class="text-lg">{{$aliquota}}%</div>
    </div>
    <div class="flex justify-between items-center p-4 border-b-2 border-gray-300">
        <div class="color-text-grey">VALOR</div>
        <div class="text-lg">R$ {{$valor}}</div>
    </div>
    <div class="text-gray-700 text-xs py-4 px-8">
        SOLICITADO EM {{\Carbon\Carbon::parse($dataEmissao)->format('d/m/Y')}}<br/><br/>
        @if ($statusProcessamento == 'Em análise')
            <x-svg.refresh />{{$statusProcessamento}}
        @endif
        @if ($statusProcessamento == 'Emitida')
            <x-svg.refresh />{{$statusProcessamento}}
        @endif
        @if ($statusProcessamento == 'Cancelada')
            <x-svg.refresh />{{$statusProcessamento}}
        @endif
        @if ($statusProcessamento == 'Erro')
            <x-svg.refresh />{{$statusProcessamento}}
        @endif
    </div>
</div>