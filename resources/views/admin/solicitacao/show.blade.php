<x-app-layout>

    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <x-container :tabs="[['url' => '', 'active' => '', 'title' => 'DETALHES DA SOLICITAÇÃO']]">

        <!-- Name -->
        <div class="relative">
            <x-form.label for="nome_cliente" value="EMISSOR" />
            <x-form.input class="w-full bg-grey-darker" name="nome_cliente" type="text" value="{{ $solicitacao->cliente->razao_social }}" readonly />
        </div>

        <!-- cpf_cnpj -->
        <div>
            <x-form.label for="cpf_cnpj" value="CPF/CNPJ" />
            <x-form.input class="w-full bg-grey-darker" name="cpf_cnpj" type="text" value="{{ $solicitacao->cliente->cpf_cnpj }}" readonly />
        </div>

        <!-- Nome Tomador -->
        <div class="relative">
            <x-form.label for="busca-tomador" value="TOMADOR" />
            <x-form.input type="text" class="w-full bg-grey-darker" name="busca-tomador" value="{{ $solicitacao->tomador->nome }}" readonly />
        </div>

        <!-- cpf_cnpj Tomador -->
        <div>
            <x-form.label for="cpf_cnpj_tomador" value="CPF/CNPJ" />
            <x-form.input class="w-full bg-grey-darker" type="text" name="cpf_cnpj_tomador" value="{{ $solicitacao->tomador->cpf_cnpj }}" readonly />
        </div>

        <div class="grid grid-cols-2 gap-32">
            <!-- Servico -->
            <div>
                <x-form.label for="tipoServico" value="TIPO DE SERVIÇO" />
                <x-form.input class="w-80 bg-grey-darker" type="text" name="cpf_cnpj_tomador" value="{{$solicitacao->servico->nome}}" readonly />
            </div>

            <!-- Data Emissao -->
            <div>
                <x-form.label for="dataEmissao" value="DATA DE EMISSÃO" />
                <x-form.input class="w-80 p-2 bg-grey-darker" name="dataEmissao" value="{{ $solicitacao->data_emissao }}" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-x-32">
            <!-- Valor -->
            <div>
                <x-form.label for="valor_nota" value="VALOR NOTA (R$)" />
                <x-form.input class="w-80 bg-grey-darker" type="text" name="valorNota" value="{{ $solicitacao->valor }}" readonly/>
            </div>

            <!-- Observacoes -->
            <div>
                <x-form.label for="observacoes" value="OBSERVAÇÕES" />
                <textarea class="w-80 border-input border-white rounded focus:border-yellow-400 focus:ring-yellow-200 bg-grey-darker" type="text" name="observacoes" rows="1" maxlength="255" readonly>
                    {{ $solicitacao->observacoes }}
                </textarea>
            </div>
        </div>      

        @if($solicitacao->status_nota_fiscal_id === 1 || $solicitacao->status_nota_fiscal_id === 4)
        <!-- Console -->
        <div class="relative">
            <x-form.label for="console" value="CONSOLE" />
            <div class="w-full border-input h-48 overflow-auto border-white rounded focus:border-yellow-400 focus:ring-yellow-200 bg-gray-800" type="text" name="console" readonly>
                @foreach(explode('|', $solicitacao->console) as $key => $log)
                    <p class="p-2 text-white">{{$log}}</p>
                @endforeach
            </div>
        </div>
        @endif




            <div class="flex justify-between items-center">
                <div class="flex-start">
                @if ($solicitacao->status_nota_fiscal_id === 1)
                    <a href="{{route('downloadNota', $solicitacao->id)}}" title="DOWNLOAD"
                    class="inline-flex bg-btn-yellow rounded px-3 py-2 hover:bg-transparent border border-transparent hover:border-black">
                        <div class=""><x-svg.download /></div>
                    </a>
                @endif
                </div>
                <div class="flex-end">
                    <x-button type="button">Cancelar Nota</x-button>
                </div>
            </div>


    </x-container>

</x-app-layout>

