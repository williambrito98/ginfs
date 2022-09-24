<x-app-layout>
    <div class="mt-10 text-center text-lg">
        <h2>Fórmulas</h2>
    </div>

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

    <form action="{{ route('formulas.store') }}" method="POST">
        @csrf
    <x-table>
        <x-slot name="columns">
            <tr class="bg-btn-dropdown-client">
                <th class="w-1/4 color-header-table">Valor Mínimo (R$)</th>
                <th class="w-1/4 color-header-table">Valor Máximo (R$)</th>
                <th class="w-1/4 color-header-table">Índice (%)</th>
                <th class="w-1/4 color-header-table">Fator Redutor (R$)</th>
                <th class="w-1/4 color-header-table">ISS Retido DAS (%)</th>
            </tr>
        </x-slot>

        <x-slot name="content">
            @foreach ($listaDeFormulas as $registro)
            <tr>
                <td><input type="text" class="form-control" name="valor_minimo[]" value="{{$registro->valor_minimo}}"></td>
                <td><input type="text" class="form-control" name="valor_maximo[]" value="{{$registro->valor_maximo}}"></td>
                <td><input type="text" class="form-control" name="indice[]" value="{{$registro->indice}}"></td>
                <td><input type="text" class="form-control" name="fator_redutor[]" value="{{$registro->fator_redutor}}"></td> 
                <td><input type="text" class="form-control" name="iss_retido_das[]" value="{{$registro->iss_retido_das}}"></td> 
                <td style="text-align:center"><a href="#" id="remove-row">Remover</a></td>
            </tr>
            @endforeach
        </x-slot>
    </x-table>
    <br/>
    <a href="#" id="add-row">Adicionar</a>
    <br/>
    <button type="submit" class="clear-both">Salvar</button>
</form>
</x-app-layout>

<script type="text/javascript">
    $('#add-row').on('click',function(){
        const row = 
        '<tr>' + 
        '<td><input type="text" class="form-control" name="valor_minimo[]"></td>' + 
        '<td><input type="text" class="form-control" name="valor_maximo[]"></td>' + 
        '<td><input type="text" class="form-control" name="indice[]"></td>' + 
        '<td><input type="text" class="form-control" name="fator_redutor[]"></td>' + 
        '<td><input type="text" class="form-control" name="iss_retido_das[]"></td>' + 
        '<td style="text-align:center"><a href="#" id="remove-row">Remover</a></td>'+
        + '</tr>';

        $('tbody').append(row);
    });

    // $('#remove-row').on('click',function(){
    //     $('#remove-row').remove();
    // });
</script>    