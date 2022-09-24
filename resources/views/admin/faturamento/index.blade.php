<x-app-layout>
    <div class="mt-10 text-center text-lg">
        <h2>Faturamento Total</h2>
    </div>
    <form action={{ route('faturamento.store') }} method="POST">
    <hr>

    @if(count($errors) > 0 )
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ \Session::get('success') }}</li>
            </ul>
        </div>
    @endif

    {{-- @can('adicionar-faturamento') --}}

    {{-- @endcan --}}
    <p id="razao-social">{{old('nomeCliente') ?? ''}}</p>
    <div id="tabela-faturamento" style="display:block">
    <x-table>
        <x-slot name="columns">
            <tr class="bg-btn-dropdown-client">
                <th class="w-1/4 color-header-table">Mês</th>
                <th class="w-1/4 color-header-table">Total Faturamento Ext. (R$)</th>
                <th class="w-1/4 color-header-table">Total Emissões pelo Sistema</th>
                <th class="w-1/4 color-header-table">Total</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            <tr>
                <td name="mes12" id="mes-12">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno12" class="form-control" id="total-fat-externo-12" value="{{old('totalFatExterno12') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento12" id="total-faturamento-12">R$ 0,00</td>
                <td name="totalMes12" id="total-mes-12">R$ {{old('inputTotalMes12') ?? 0}}</td>
            </tr>
            <tr>
                <td name="mes11" id="mes-11">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno11" class="form-control" id="total-fat-externo-11" value="{{old('totalFatExterno11') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento11" id="total-faturamento-11">R$ 0,00</td>
                <td name="totalMes11" id="total-mes-11">R$ {{old('inputTotalMes11') ?? 0}}</td>
            </tr>
            <tr>
                <td name="mes10" id="mes-10">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno10" class="form-control" id="total-fat-externo-10" value="{{old('totalFatExterno10') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento10" id="total-faturamento-10">R$ 0,00</td>
                <td name="totalMes10" id="total-mes-10">R$ {{old('inputTotalMes10') ?? 0}}</td>
            </tr>
            <tr>
                <td name="mes9" id="mes-9">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno9" class="form-control" id="total-fat-externo-9" value="{{old('totalFatExterno9') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento9" id="total-faturamento-9">R$ 0,00</td>
                <td name="totalMes9" id="total-mes-9">R$ {{old('inputTotalMes9') ?? 0}}</td>
            </tr>
            <tr>
                <td name="mes8" id="mes-8">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno8" class="form-control" id="total-fat-externo-8" value="{{old('totalFatExterno8') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento8" id="total-faturamento-8">R$ 0,00</td>
                <td name="totalMes8" id="total-mes-8">R$ {{old('inputTotalMes8') ?? 0}}</td>
            </tr>
            <tr>
                <td name="mes7" id="mes-7">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno7" class="form-control" id="total-fat-externo-7" value="{{old('totalFatExterno7') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento7" id="total-faturamento-7">R$ 0,00</td>
                <td name="totalMes7" id="total-mes-7">R$ {{old('inputTotalMes7') ?? 0}}</td>
            </tr>
            <tr>
                <td name="mes6" id="mes-6">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno6" class="form-control" id="total-fat-externo-6" value="{{old('totalFatExterno6') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento6" id="total-faturamento-6">R$ 0,00</td>
                <td name="totalMes6" id="total-mes-6">R$ {{old('inputTotalMes6') ?? 0}}</td>
            </tr>
            <tr>
                <td name="mes5" id="mes-5">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno5" class="form-control" id="total-fat-externo-5" value="{{old('totalFatExterno5') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento5" id="total-faturamento-5">R$ 0,00</td>
                <td name="totalMes5" id="total-mes-5">R$ {{old('inputTotalMes5') ?? 0}}</td>
            </tr>
            <tr>
                <td name="mes4" id="mes-4">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno4" class="form-control" id="total-fat-externo-4" value="{{old('totalFatExterno4') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento4" id="total-faturamento-4">R$ 0,00</td>
                <td name="totalMes4" id="total-mes-4">R$ {{old('inputTotalMes4') ?? 0}}</td>
            </tr>
            <tr>
                <td name="mes3" id="mes-3">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno3" class="form-control" id="total-fat-externo-3" value="{{old('totalFatExterno3') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento3" id="total-faturamento-3">R$ 0,00</td>
                <td name="totalMes3" id="total-mes-3">R$ {{old('inputTotalMes3') ?? 0}}</td>
            </tr>
            <tr>
                <td name="mes2" id="mes-2">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno2" class="form-control" id="total-fat-externo-2" value="{{old('totalFatExterno2') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento2" id="total-faturamento-2">R$ 0,00</td>
                <td name="totalMes2" id="total-mes-2">R$ {{old('inputTotalMes2') ?? 0}}</td>
            </tr>
            <tr>
                <td name="mes1" id="mes-1">{{ $anoAtual->modify('-1 month')->format('m/Y'); }}</td>
                <td><input type="text" name="totalFatExterno1" class="form-control" id="total-fat-externo-1" value="{{old('totalFatExterno1') ?? ''}}" placeholder=""></td>
                <td name="totalFaturamento1" id="total-faturamento-1">R$ 0,00</td>
                <td name="totalMes1" id="total-mes-1">R$ {{old('inputTotalMes1') ?? 0}}</td>
            </tr>

        </x-slot>
    </x-table>
    </div>

    <input type="hidden" name="inputMesAno12" id='input-mes-ano-12' value="{{old('inputMesAno12') ?? ''}}" readonly>
    <input type="hidden" name="inputMesAno11" id='input-mes-ano-11' value="{{old('inputMesAno11') ?? ''}}" readonly>
    <input type="hidden" name="inputMesAno10" id='input-mes-ano-10' value="{{old('inputMesAno10') ?? ''}}" readonly>
    <input type="hidden" name="inputMesAno9" id='input-mes-ano-9' value="{{old('inputMesAno9') ?? ''}}" readonly>
    <input type="hidden" name="inputMesAno8" id='input-mes-ano-8' value="{{old('inputMesAno8') ?? ''}}" readonly>
    <input type="hidden" name="inputMesAno7" id='input-mes-ano-7' value="{{old('inputMesAno7') ?? ''}}" readonly>
    <input type="hidden" name="inputMesAno6" id='input-mes-ano-6' value="{{old('inputMesAno6') ?? ''}}" readonly>
    <input type="hidden" name="inputMesAno5" id='input-mes-ano-5' value="{{old('inputMesAno5') ?? ''}}" readonly>
    <input type="hidden" name="inputMesAno4" id='input-mes-ano-4' value="{{old('inputMesAno4') ?? ''}}" readonly>
    <input type="hidden" name="inputMesAno3" id='input-mes-ano-3' value="{{old('inputMesAno3') ?? ''}}" readonly>
    <input type="hidden" name="inputMesAno2" id='input-mes-ano-2' value="{{old('inputMesAno2') ?? ''}}" readonly>
    <input type="hidden" name="inputMesAno1" id='input-mes-ano-1' value="{{old('inputMesAno1') ?? ''}}" readonly>

    <input type="hidden" name="inputTotalMes12" id='input-total-mes-12' value="{{old('inputTotalMes12') ?? ''}}" readonly>
    <input type="hidden" name="inputTotalMes11" id='input-total-mes-11' value="{{old('inputTotalMes11') ?? ''}}" readonly>
    <input type="hidden" name="inputTotalMes10" id='input-total-mes-10' value="{{old('inputTotalMes10') ?? ''}}" readonly>
    <input type="hidden" name="inputTotalMes9" id='input-total-mes-9' value="{{old('inputTotalMes9') ?? ''}}" readonly>
    <input type="hidden" name="inputTotalMes8" id='input-total-mes-8' value="{{old('inputTotalMes8') ?? ''}}" readonly>
    <input type="hidden" name="inputTotalMes7" id='input-total-mes-7' value="{{old('inputTotalMes7') ?? ''}}" readonly>
    <input type="hidden" name="inputTotalMes6" id='input-total-mes-6' value="{{old('inputTotalMes6') ?? ''}}" readonly>
    <input type="hidden" name="inputTotalMes5" id='input-total-mes-5' value="{{old('inputTotalMes5') ?? ''}}" readonly>
    <input type="hidden" name="inputTotalMes4" id='input-total-mes-4' value="{{old('inputTotalMes4') ?? ''}}" readonly>
    <input type="hidden" name="inputTotalMes3" id='input-total-mes-3' value="{{old('inputTotalMes3') ?? ''}}" readonly>
    <input type="hidden" name="inputTotalMes2" id='input-total-mes-2' value="{{old('inputTotalMes2') ?? ''}}" readonly>
    <input type="hidden" name="inputTotalMes1" id='input-total-mes-1' value="{{old('inputTotalMes1') ?? ''}}" readonly>

    <input type="hidden" name="nomeCliente" id='nome-cliente' value="{{old('nomeCliente') ?? ''}}" readonly>
    <input type="hidden" name="idCliente" id='id-cliente' value="{{old('idCliente') ?? ''}}" readonly>
    <button type="submit" class="bg-black text-white p-3 mt-4">Salvar</button>
</form>
</x-app-layout>

<script src="{{ asset('js/currency.js')}}" defer></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#total-fat-externo-12, #total-fat-externo-1, #total-fat-externo-2, #total-fat-externo-3, #total-fat-externo-4, #total-fat-externo-5, #total-fat-externo-6, #total-fat-externo-7, #total-fat-externo-8, #total-fat-externo-9, #total-fat-externo-10, #total-fat-externo-11')
        .mask('#.##0,00', {reverse: true})
        .attr('maxlength','14');

        if($('#id-cliente').val()){
            $('#tabela-faturamento').show();
        }

        for (let i = 1; i <= 12; i++) {
            const idCampo = '#mes-' + i;
            const idCampoMesAno = '#input-mes-ano-' + i;

            $(idCampoMesAno).val($(idCampo).text());
        }
    });

    $('#id-cliente').on('change', function(e) {
        const idCliente = $(this).val();
        clearFaturamentoFields();

        let url = '{{ route("getFaturamentoAnualFromCliente", ":id") }}';
        url = url.replace(':id', idCliente);

        $.ajax({
           url: url,
           type: 'get',
           dataType: 'json',
           success: function(response) {
               if (response != null) {
                    $('#tabela-faturamento').show();

                    let mes = 12;
                    let index = response.length - 1;
                    for (let i = 11; i >= 0; i--) {
                        const mesString = mes.toString();

                        const idCampo = '#total-fat-externo-' + mesString;
                        const idCampoMesAno = '#mes-' + mesString;

                        const mesAnoDate = new Date(response[index].mes_ano_faturamento);
                        const stringMesAno = mesAnoDate.toLocaleDateString("pt-BR", { year:"numeric", month:"numeric"});

                        if($(idCampoMesAno).text() === stringMesAno){
                            $(idCampo).val(response[index].valor_faturamento_externo);
                            calculateTotalMes(mes, response[index].valor_faturamento_externo, response[index].valor_faturamento);
                            index--;
                        }
                        mes--;
                    }
               }
           }
       });
    });

    $('#total-fat-externo-12, #total-fat-externo-1, #total-fat-externo-2, #total-fat-externo-3, #total-fat-externo-4, #total-fat-externo-5, #total-fat-externo-6, #total-fat-externo-7, #total-fat-externo-8, #total-fat-externo-9, #total-fat-externo-10, #total-fat-externo-11')
    .on('keyup', function (e) {
        const valor = $(this).val();
        const idCampo = $(this).attr('id');

        let mes = idCampo.substring(18);
        const idCampoFatSistema = '#total-faturamento-' + mes;
        const idCampoFatExterno = '#total-fat-externo-' + mes;

        const fatSistema = currencyBRL($(idCampoFatSistema).text()).value;
        const fatExterno = $(idCampoFatExterno).val();

        calculateTotalMes(mes, fatExterno, fatSistema);
    });

    function clearFaturamentoFields()
    {
        for (let i = 1; i <= 12; i++) {
            const idCampo = '#total-fat-externo-' + i;
            $(idCampo).val('');
        }
    }

    function calculateTotalMes(numeroMes, fatExt = 0, fatSistema = 0)
    {
        const idCampoInputHidden = '#input-total-mes-' + numeroMes;
        const idCampoTotal = '#total-mes-' + numeroMes;

        const valorFatExt = currencyBRL(fatExt).value;
        const valorFatSistema = currencyBRL(fatSistema).value;

        const totalMes = currencyBRL(fatExt).add(currencyBRL(fatSistema));

        $(idCampoTotal).html(totalMes.format());
        $(idCampoInputHidden).val(totalMes.format().substring(2));
    }

    const currencyBRL = value => currency(value, {
        symbol: 'R$',
        decimal: ',',
        separator: '.'
    });
</script>

