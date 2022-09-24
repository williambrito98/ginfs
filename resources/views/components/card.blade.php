@props(['id', 'nomeCliente', 'razaoSocial', 'aliquota', 'valor', 'statusProcessamento', 'dataEmissao'])

<div class="rounded-lg overflow-hidden bg-grey w-64 mx-auto hover:shadow-xl">
    <div class="border-b border-gray-300 p-2">
        <div class="mb-2 color-text-grey">PRESTADOR</div>
        <div class="text-sm mx-4 h-20">{{$nomeCliente}}</div>
    </div>
    <div class="flex justify-between items-center p-2 border-b border-gray-300">
        <div class="color-text-grey">VALOR</div>
        <div class="text-lg">R$ {{$valor}}</div>
    </div>
    <div class="text-gray-700 text-xs py-4 px-8 border-b border-gray-300">
        SOLICITADO EM {{\Carbon\Carbon::parse($dataEmissao)->format('d/m/Y')}}<br/>
        @if ($statusProcessamento == 'Em análise')
        <div class="flex items-center mt-2">
            <div class="mr-2"><x-svg.refresh /></div>
            <div class="text-base">{{$statusProcessamento}}</div>
        </div>
        @endif
        @if ($statusProcessamento == 'Emitida')
        <div class="flex items-center mt-2">
            <div class="mr-2"><x-svg.checkGreen /></div>
            <div class="text-base">{{$statusProcessamento}}</div>
        </div>
        @endif
        @if ($statusProcessamento == 'Cancelada')
        <div class="flex items-center mt-2">
            <div class="mr-2"><x-svg.canceled /></div>
            <div class="text-base">{{$statusProcessamento}}</div>
        @endif
        @if ($statusProcessamento == 'Erro')
        <div class="flex items-center mt-2">
            <div class="mr-2"><x-svg.error /></div>
            <div class="text-base">{{$statusProcessamento}}</div>
        </div>
        @endif
    </div>
</div>