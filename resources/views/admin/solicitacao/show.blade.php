<x-app-layout>
    
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr class="mb-3">

    <x-container :tabs="[['url' => '', 'active' => '', 'title' => 'DETALHES DA SOLICITAÇÃO']]">
    
        <!-- Name -->
        <div class="relative">
            <x-form.label for="nome_cliente" value="EMISSOR" />
            <x-form.input class="w-full bg-grey-darker" name="nome_cliente" type="text" value="{{ $solicitacao->cliente->razao_social }}" readonly />
        </div>

        <div class="grid grid-cols-2 gap-x-32">
            <!-- cpf_cnpj -->
            <div> 
                <x-form.label for="cpf_cnpj" value="CPF/CNPJ" />
                <x-form.input class="w-80 bg-grey-darker" name="cpf_cnpj" type="text" value="{{ $solicitacao->cliente->cpf_cnpj }}" readonly />
            </div>

            <!-- inscricao_municipal -->
            <div>
                <x-form.label for="inscricao_municipal" value="INSCRIÇÃO MUNICIPAL" />
                <x-form.input class="w-80 bg-grey-darker" name="inscricao_municipal" type="text" value="{{ $solicitacao->cliente->inscricao_municipal }}" readonly />
            </div>
        </div>

        <!-- Nome Tomador -->
        <div class="relative">
            <x-form.label for="busca-tomador" value="TOMADOR" />
            <x-form.input type="text" class="w-full bg-grey-darker" name="busca-tomador" value="{{ $solicitacao->tomador->nome }}" readonly />
        </div>

        <div class="grid grid-cols-2 gap-x-32">
            <!-- cpf_cnpj Tomador -->
            <div>
                <x-form.label for="cpf_cnpj_tomador" value="CPF/CNPJ" />
                <x-form.input class="w-80 bg-grey-darker" type="text" name="cpf_cnpj_tomador" value="{{ $solicitacao->tomador->cpf_cnpj }}" readonly />
            </div>

            <!-- inscricao_municipal Tomador -->
            <div>
                <x-form.label for="inscricao_municipal_tomador" value="INSCRIÇÃO MUNICIPAL" />
                <x-form.input class="w-80 bg-grey-darker" type="text" name="inscricao_municipal_tomador" value="{{ $solicitacao->tomador->inscricao_municipal }}" readonly />
            </div>
        </div>

        <!-- Servico -->
        <div>
            <x-form.label for="tipoServico" value="TIPO DE SERVIÇO" />
            <textarea class="w-full border-input border-white rounded focus:border-yellow-400 focus:ring-yellow-200 bg-grey-darker" type="text" name="tipoServico" rows="5" maxlength="255" readonly>
                {{$solicitacao->servico->nome}}
            </textarea>
        </div>

        <br />

        <div class="grid grid-cols-2 gap-x-32">
            <!-- Valor -->
            <div>
                <x-form.label for="valor_nota" value="VALOR NOTA (R$)" />
                <x-form.input class="w-80 bg-grey-darker" type="text" name="valorNota" value="{{ $solicitacao->valor }}" readonly/>
            </div>

            <!-- Data Emissao -->
            <div>
                <x-form.label for="dataEmissao" value="DATA DE EMISSÃO" />
                <x-form.input class="w-80 p-2 bg-grey-darker" name="dataEmissao" value="{{ $solicitacao->data_emissao }}" />
            </div>
        </div>

        <!-- Observacoes -->
        <div class="relative">
            <x-form.label for="observacoes" value="OBSERVAÇÕES" />
            <textarea class="w-full border-input border-white rounded focus:border-yellow-400 focus:ring-yellow-200 bg-grey-darker" type="text" name="observacoes" rows="5" maxlength="255" readonly>
                {{ $solicitacao->observacoes }}
            </textarea>
        </div>


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

