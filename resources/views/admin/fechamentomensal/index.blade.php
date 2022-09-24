<x-app-layout>
    <div class="mt-10 text-center text-lg">
        <h2>Fechamento Mensal</h2>
    </div>

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

    <form class="form-inline" method="GET">
        <div class="form-group mb-2">
            <label for="filter" class="col-sm-2 col-form-label">Filtro: </label>
            <input type="text" class="form-control" id="filter" name="filter" placeholder="Razão Social"
                value="{{ $filter }}">
        </div>

        <label for="dataInicial">Data Inicial: </label>
        <input name="dataInicial" id="data-inicial" class="form-control" style="display: inline;" value=""
            placeholder="Data inicial" type="month" />

        <label for="dataFinal">Data Final: </label>
        <input name="dataFinal" id="data-final" class="form-control" style="display: inline;" value="" placeholder=""
            type="month" />

        <button type="submit" class="clear-both">Filtrar</button>
    </form>

    <x-table>
        <x-slot name="columns">
            <tr class="bg-btn-dropdown-client">
                <th class="w-1/4 color-header-table">CNPJ/CPF</th>
                <th class="w-1/4 color-header-table">@sortablelink('razaoSocial', 'Prestador')</th>
                <th class="w-1/4 color-header-table">@sortablelink('mes_ano_faturamento', 'Mês')</th>
                <th class="w-1/4 color-header-table">@sortablelink('quantidade_emissoes', 'Qntd. Emissões')</th>
                <th class="w-1/4 color-header-table">@sortablelink('valor_faturamento', 'Faturamento Emissões pelo
                    Sistema (R$)')</th>
                <th class="w-1/4 color-header-table">@sortablelink('valor_faturamento_externo', 'Faturamento Ext. (R$)')
                </th>
                <th class="w-1/4 color-header-table">@sortablelink('total_mes', 'Total')</th>
                <th class="w-1/4 color-header-table">Alíquota</th>
                <th class="w-1/4 color-header-table"></th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($listaDeFaturamentos as $faturamento)
                <tr>
                    <td>{{ $faturamento->cliente->cpf_cnpj }}</td>
                    <td>{{ $faturamento->cliente->razao_social }}</td>
                    <td>
                        {{ ucfirst(\Carbon\Carbon::createFromDate($faturamento->mes_ano_faturamento)->formatLocalized('%B/%Y')) }}
                    </td>
                    <td>{{ $faturamento->quantidade_emissoes }}</td>
                    <td>{{ $faturamento->valor_faturamento }}</td>
                    <td>{{ $faturamento->valor_faturamento_externo }}</td>
                    <td>{{ $faturamento->total_mes }}</td>
                    <td>{{ $faturamento->aliquota }}%</td>
                    <td>
                        @if ($faturamento->encerrado == 'N')
                            <a class="underline" href="{{ route('encerrarFaturamentoMes', $faturamento->id) }}">
                                Encerrar
                            </a>
                        @else
                            Encerrado
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
    {{ $listaDeFaturamentos->appends(Request::except('page'))->render() }}
</x-app-layout>
