<!-- Name -->
<div class="relative">
    <x-form.label for="nome_cliente" value="EMISSOR" />
    <x-form.input type="text" class="w-full" name="nome_cliente" id="busca-cliente" value="{{old('nome_cliente') ?? ''}}" placeholder="Pesquisar..." />
    <div id="busca-cliente-list" class="w-full z-50 relative" hidden></div>
</div>

<div class="relative">
    <!-- cpf_cnpj -->
    <x-form.label for="cpf_cnpj" value="CPF/CNPJ" />
    <x-form.input class="w-full bg-grey-darker" id="cpf_cnpj" data-mask-for-cpf-cnpj type="text" name="cpf_cnpj" value="{{ $tomador->cpf_cnpj ?? old('cpf_cnpj') }}" readonly required />
</div>

<!-- Nome Tomador -->
<div class="relative">
    <x-form.label for="busca-tomador" value="TOMADOR" />
    <x-form.input type="text" class="w-full" name="busca-tomador" id="busca-tomador" value="{{old('busca-tomador') ?? ''}}" placeholder="Pesquisar..." />
    <div id="busca-tomador-list" class="w-full z-50 relative" hidden></div>
</div>

<div class="relative">
    <x-form.label for="cpf_cnpj_tomador" value="CPF/CNPJ" />
    <x-form.input class="w-full bg-grey-darker" id="cpf_cnpj-tomador" data-mask-for-cpf-cnpj type="text" name="cpf_cnpj_tomador" value="{{ $tomador->cpf_cnpj ?? old('cpf_cnpj_tomador') }}" readonly required />
</div>

<div class="grid grid-cols-2 gap-x-32">
    <!-- Servico -->
    <div>
        <x-form.label for="tipoServico" value="TIPO DE SERVIÇO" />
        <select id="tipo-servico" class="w-80 border-input border-white rounded focus:border-yellow-400 focus:ring-yellow-200" name="tipoServico" value="{{old('tipoServico') ?? ''}}" readonly required>
        </select>
    </div>

    <!-- Data Emissao -->
    <div>
        <x-form.label for="dataEmissao" value="DATA DE EMISSÃO" />
        <x-form.input
            class="w-80"
            name="dataEmissao"
            id="data-emissao"
            value="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
            type="date"/>
    </div>
</div>

<div class="grid grid-cols-2 gap-x-32">
    <!-- Valor -->
    <div>
        <x-form.label for="valor_nota" value="VALOR NOTA (R$)" />
        <x-form.input class="w-80" id="valor-nota" name="valorNota" type="text" value="{{old('valorNota') ?? ''}}" autofocus/>
    </div>

    <!-- Observacoes -->
    <div>
        <x-form.label for="observacoes" value="OBSERVAÇÕES" />
        <textarea type="text" id="observacoes" class="w-80 border-input border-white rounded focus:border-yellow-400 focus:ring-yellow-200" rows="1" maxlength="255" name="observacoes">{{old('observacoes') ?? ''}}</textarea>
        <div id="count">
            <span id="current_count">0</span>
            <span id="maximum_count">/ 255</span>
        </div>
        @error('observacoes')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>


<input type="hidden" name="idCliente" id='id-cliente' value="{{ old('idCliente') ?? '' }}" readonly>
<input type="hidden" name="idTomador" id='id-tomador' value="{{ old('idTomador') ?? '' }}" readonly>

<script type="text/javascript">
    $('#valor-nota')
        .mask('#.##0,00', {
            reverse: true
        })
        .attr('maxlength', '14');

    $('#busca-cliente').autocomplete({
        source: '{!! URL::route('autocomplete') !!}',
        appendTo: "#busca-cliente-list",
        minlenght: 1,
        response: function(event, ui) {
            if (!ui.content.length) {
                var noResult = {
                    value: "",
                    label: "Nenhum resultado encontrado."
                };
                ui.content.push(noResult);
            }

            $('#busca-cliente-list').show();
        },
        select: function(event, ui) {
            if (ui.item.label === "Nenhum resultado encontrado.") {
                event.preventDefault();
            } else {
                $('#razao-social').html(ui.item.razao_social);
                $('#cpf_cnpj').val(ui.item.cpf_cnpj);
                $('#busca-cliente').val(ui.item.razao_social);
                $('#id-cliente').val(ui.item.id).trigger('change');
                return false;
            }
        },
        close: function(event, ui) {
            $('#busca-cliente-list').hide();
        },
    });

    $('#id-cliente').on('change', function(e) {
        let urlBuscaTomador = '{{ route('autocompleteByCliente', ':idCliente') }}';
        urlBuscaTomador = urlBuscaTomador.replace(':idCliente', $('#id-cliente').val());

        $('#busca-tomador').autocomplete({
            source: urlBuscaTomador,
            appendTo: "#busca-tomador-list",
            minlenght: 1,
            autoFocus: true,
            response: function(event, ui) {
                if (!ui.content.length) {
                    ui.content.push(getNotFoundMessage());
                }

                $('#busca-tomador-list').show();
            },
            select: function(event, ui) {
                if (ui.item.label === "Nenhum resultado encontrado.") {
                    event.preventDefault();
                } else {
                    $('#busca-tomador').val(ui.item.nome + ' - ' + ui.item.cpf_cnpj );
                    $('#cpf_cnpj-tomador').val(ui.item.cpf_cnpj);
                    $('#id-tomador').val(ui.item.id).trigger('change');

                    $('#tipo-servico option').each(function(i) {
                        $(this).remove();
                    });

                    ui.item.listaDeServicos.forEach(element => {
                        $('#tipo-servico').append(createOption(element.id, `${element.codigo} - ${element.cod_atividade}`));
                    });

                    return false;
                }
            },
            response: function(event, ui) {
                if (!ui.content.length) {
                    ui.content.push(getNotFoundMessage());
                }

                $('#busca-tomador-list').show();
            },
            close: function(event, ui) {
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
        return {
            value: "",
            label: "Nenhum resultado encontrado."
        };
    }

    function createOption(value, text) {
        let opt = $(`<option>${text}</option>`)
        opt.val(value)
        return opt
    }
</script>
