<x-app-layout>

    <x-title title="Fechamento mensal" />
    <hr class="mb-3">

    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
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

    <form class="form-control" method="GET">
        <div class="flex justify-between items-center space-x-6">
            <div class="flex-basis-70">
                <input type="text" id="filter" name="filter" placeholder="Razão Social"
                    class="form-control border border-black rounded focus:border-yellow-400 focus:ring-yellow-200 w-full"
                    value="{{ $filter }}">
            </div>

            <div class="flex-basis-15">
                <input name="dataInicial" id="data-inicial" value="" type="text"
                    class="form-control border border-black rounded focus:border-yellow-400 focus:ring-yellow-200 w-full"
                    placeholder="Data inicial" />
            </div>

            <div class="flex-basis-15">
                <input name="dataFinal" id="data-final" value="" type="text"
                    class="form-control border border-black rounded focus:border-yellow-400 focus:ring-yellow-200 w-full"
                    placeholder="Data final" />
            </div>

            <x-button type="submit">Filtrar</x-button>
        </div>
    </form>

    <x-table class="rounded-xl">
        <x-slot name="columns">
            <tr>
                <th class="w-3/12 color-header-table py-2">@sortablelink('razaoSocial', 'PRESTADOR')</th>

                <th class="w-2/12 color-header-table">@sortablelink('quantidade_emissoes', 'QNTD EMISSÕES')</th>
                <th class="w-1/12 color-header-table">@sortablelink('valor_faturamento', 'EMISSÕES')</th>
                <th class="w-2/12 color-header-table">@sortablelink('valor_faturamento_externo', 'FAT EXTERNO')</th>
                <th class="w-1/12 color-header-table">@sortablelink('total_mes', 'TOTAL')</th>
                <th class="w-1/12 color-header-table">@sortablelink('mes_ano_faturamento', 'MÊS')</th>
                <th class="w-1/12 color-header-table">ALÍQUOTA</th>
                <th class="w-1/12 color-header-table"></th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($listaDeFaturamentos as $faturamento)
                <tr class="border-top">
                    <td class="py-2 px-1">{{ $faturamento->cliente->razao_social }}</td>
                    <td>{{ $faturamento->quantidade_emissoes }}</td>
                    <td>R$<br> {{ $faturamento->valor_faturamento }}</td>
                    <td>R$<br> {{ $faturamento->valor_faturamento_externo }}</td>
                    <td>R$<br> {{ $faturamento->total_mes }}</td>
                    <td>
                        {{ ucfirst(\Carbon\Carbon::createFromDate($faturamento->mes_ano_faturamento)->formatLocalized('%b')) }}
                        <br>
                        {{ ucfirst(\Carbon\Carbon::createFromDate($faturamento->mes_ano_faturamento)->formatLocalized('%Y')) }}
                    </td>
                    <td>{{ $faturamento->aliquota }}%</td>
                    <td>
                        @if ($faturamento->encerrado == 'N')
                            <a class="cursor-pointer text-red"
                                href="{{ route('encerrarFaturamentoMes', $faturamento->id) }}">
                                Encerrar
                            </a>
                        @else
                            <a class="text-green">
                                Encerrado
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
    <br>
    {{ $listaDeFaturamentos->appends(Request::except('page'))->render() }}

    <script>
        $(document).ready(function() {
            $('#data-inicial').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'yy-mm',
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            })

            $('#data-final').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'yy-mm',
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            })
        })
    </script>

</x-app-layout>
