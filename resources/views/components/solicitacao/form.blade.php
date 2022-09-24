<!-- Name -->
<div class="relative">
    <x-form.label for="nome_cliente" :value="__('Emissor')" />
    <x-form.input type="text" name="nome_cliente" class="w-full mt-2" id="busca-cliente" value="{{old('nome_cliente') ?? ''}}" placeholder="Pesquisar..." />
    <div id="busca-cliente-list" class=" border rounded p-3 absolute bg-white" hidden></div>
</div>

<div class="flex justify-between">
    <!-- cpf_cnpj -->
    <div>
        <x-form.label for="cpf_cnpj" :value="__('CPF/CNPJ')" />
        <x-form.input id="cpf_cnpj" data-mask-for-cpf-cnpj type="text" name="cpf_cnpj" value="{{ $tomador->cpf_cnpj ?? old('cpf_cnpj') }}" required autofocus readonly />
    </div>

    <!-- inscricao_municipal -->
    <div>
        <x-form.label for="inscricao_municipal" :value="__('Inscricao Municipal')" />
        <x-form.input id="inscricao_municipal" type="text" name="inscricao_municipal" value="{{ $tomador->inscricao_municipal ?? old('inscricao_municipal') }}" required autofocus readonly />
    </div>
</div>

<!-- Nome Tomador -->
<div class="relative">
    <x-form.label for="busca-tomador" :value="__('Tomador')" />
    <x-form.input type="text" class="w-full mt-2" name="busca-tomador" id="busca-tomador" value="{{old('busca-tomador') ?? ''}}" placeholder="Pesquisar..." />
    <div id="busca-tomador-list" class="border rounded p-3 absolute bg-white" hidden></div>
</div>

<div class="flex justify-between">
    <!-- cpf_cnpj Tomador -->
    <div>
        <x-form.label for="cpf_cnpj_tomador" :value="__('CPF/CNPJ')" />
        <x-form.input id="cpf_cnpj-tomador" data-mask-for-cpf-cnpj type="text" name="cpf_cnpj_tomador" value="{{ $tomador->cpf_cnpj ?? old('cpf_cnpj_tomador') }}" required autofocus readonly />
    </div>

    <!-- inscricao_municipal Tomador -->
    <div>
        <x-form.label for="inscricao_municipal_tomador" :value="__('Inscricao Municipal')" />
        <x-form.input id="inscricao_municipal_tomador" type="text" name="inscricao_municipal_tomador" value="{{ $tomador->inscricao_municipal ?? old('inscricao_municipal_tomador') }}" required autofocus readonly />
    </div>
</div>

<!-- Servico -->
<div class="relative">
    <x-form.label for="tipoServico" :value="__('Serviço')" />
    <select id="tipo-servico" class="w-full mt-2" name="tipoServico" value="{{old('tipoServico') ?? ''}}" readonly required>
    </select>
</div>

<br />

<div class="flex justify-between">
    <!-- Valor -->
    <div>
        <x-form.label for="valor_nota" :value="__('Valor Nota (R$)')" />
        <x-form.input id="valor-nota" name="valorNota" type="text" value="{{old('valorNota') ?? ''}}" autofocus/>
    </div>

    <!-- Data Emissao -->
    <div>
        <x-form.label for="dataEmissao" :value="__('Data da Emissão')" />
        <x-form.input 
            name="dataEmissao" 
            id="data-emissao"
            value="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
            type="date"/>
    </div>
</div>

<!-- Observacoes -->
<div class="relative">
    <x-form.label for="observacoes" :value="__('Observações')" />
    <textarea type="text" id="observacoes" class="w-full mt-2" rows="5" maxlength="255" name="observacoes">{{old('observacoes') ?? ''}}</textarea>
    <div id="count">
        <span id="current_count">0</span>
        <span id="maximum_count">/ 255</span>
    </div>
    @error('observacoes')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>

<input type="hidden" name="idCliente" id='id-cliente' value="{{old('idCliente') ?? ''}}" readonly>
<input type="hidden" name="idTomador" id='id-tomador' value="{{old('idTomador') ?? ''}}" readonly>

<script type="text/javascript">
    $('#id-cliente').on('change', function (e) {
        let urlBuscaCliente = '{{ route("autocompleteByCliente", ":idCliente") }}';

        $('#valor-nota')
            .mask('#.##0,00', {reverse: true})
            .attr('maxlength','14');

        $('#busca-cliente').autocomplete({
            source : '{!!URL::route('autocomplete')!!}',
            appendTo: "#busca-cliente-list",
            minlenght:1,
            response: function (event, ui) {
                if (!ui.content.length) {
                    var noResult = { value:"", label:"Nenhum resultado encontrado." };
                    ui.content.push(noResult);
                }

                $('#busca-cliente-list').show();
            },
            select: function (event, ui) {
                if (ui.item.label === "Nenhum resultado encontrado.") {
                    event.preventDefault();
                }else{
                    $('#razao-social').html(ui.item.razao_social);
                    $('#cpf_cnpj').val(ui.item.cpf_cnpj);
                    $('#inscricao_municipal').val(ui.item.inscricao_municipal);
                    $('#busca-cliente').val(ui.item.razao_social);
                    $('#id-cliente').val(ui.item.id).trigger('change');
                    return false;
                }
            },
            close: function (event, ui) {
                $('#busca-cliente-list').hide();
            },
        });
    });
    
    $('#id-tomador').on('change', function (e) {
        urlBuscaTomador = urlBuscaTomador.replace(':idTomador', $('#id-tomador').val());

        $('#busca-tomador').autocomplete({
            source : urlBuscaTomador,
            appendTo: "#busca-tomador-list",
            minlenght:1,
            autoFocus:true,
            response: function (event, ui) {
                if (!ui.content.length) {
                    ui.content.push(getNotFoundMessage());
                }

                $('#busca-tomador-list').show();
            },
            select: function (event, ui) {
                if (ui.item.label === "Nenhum resultado encontrado.") {
                    event.preventDefault();
                }else{
                    $('#busca-tomador').val(ui.item.nome);
                    $('#cpf_cnpj-tomador').val(ui.item.cpf_cnpj);
                    $('#inscricao_municipal_tomador').val(ui.item.inscricao_municipal);
                    $('#id-tomador').val(ui.item.id).trigger('change');

                    $('#tipo-servico option').each(function (i) {
                        $(this).remove();
                    });

                    ui.item.listaDeServicos.forEach(element => {
                        $('#tipo-servico').append(createOption(element.id, element.nome));
                    });

                    return false;
                }
            },
            response: function (event, ui) {
                if (!ui.content.length) {
                    ui.content.push(getNotFoundMessage());
                }

                $('#busca-tomador-list').show();
            },
            close: function (event, ui) {
                $('#busca-tomador-list').hide();
            },
        });
    });

    $('textarea').keyup(function() {    
        let characterCount = $(this).val().length,
            current_count = $('#current_count'),
            maximum_count = $('#maximum_count'),
            count = $('#count');
            current_count.text(characterCount); 
    });

    function getNotFoundMessage() {
        return { value:"", label:"Nenhum resultado encontrado." };
    }

    function createOption(value, text) {
            let opt = $(`<option>${text}</option>`)
            opt.val(value)
            return opt
    }
    </script>
