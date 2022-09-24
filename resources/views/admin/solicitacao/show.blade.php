<x-app-layout>
    <x-breadCrumbs :breadCrumbs="$breadCrumbs" />
    <hr/>

    <br />

    Dados do Emissor<br/>
    <br />
    Emissor: {{$solicitacao->cliente->razao_social}}

    <br />
    CPF/CNPJ: {{$solicitacao->cliente->cpf_cnpj}}

    <br />
    Inscrição Municipal: {{$solicitacao->cliente->inscricao_municipal}}

    <br/><br/>
    Dados do Tomador
    <br />
    <br />
    Tomador: {{$solicitacao->tomador->nome}}

    <br />
    CPF/CNPJ: {{$solicitacao->tomador->cpf_cnpj}}

    <br />
    Inscrição Municipal: {{$solicitacao->tomador->inscricao_municipal}}

    <br />
    Valor Nota (R$): {{$solicitacao->valor}}

    <br />
    Serviço: {{$solicitacao->servico->nome}}

    <br />
    Data da Emissão: {{$solicitacao->data_emissao}}
    <br/>

    <br />
    Observações: {{$solicitacao->observacoes}}
    <br />
    <x-button type="button">
        Cancelar Nota
    </x-button>
</x-app-layout>

