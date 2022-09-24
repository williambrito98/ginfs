<x-app-layout>
    <div class="alert absolute px-6 top-40 text-sm right-2.5 w-66 h-14 text-white rounded-lg text-center hidden"
        id="alert">
        <div class="flex w-full h-full items-center justify-center" id="alert-message">
            <x-svg.checkGreen />
        </div>
    </div>

    <x-title title="Fórmulas" />
    <hr class="mb-3">

    <form action="{{ route('formulas.store') }}" method="POST">
        @csrf
        <x-table class="rounded-xl">
            <x-slot name="columns">
                <tr>
                    <th class="w-1/5 color-header-table py-2">VALOR MÍNIMO <br> R$</th>
                    <th class="w-1/5 color-header-table">VALOR MÁXIMO <br> R$</th>
                    <th class="w-1/5 color-header-table">ÍNDICE <br> %</th>
                    <th class="w-1/5 color-header-table">FATOR REDUTOR <br> R$</th>
                    <th class="w-1/5 color-header-table">ISS RETIDO DAS <br> %</th>
                </tr>
            </x-slot>

            <x-slot name="content">
                @foreach ($listaDeFormulas as $key => $registro)
                    <tr id={{ $registro->id }}>
                        <td><input type="text"
                                class="bg-grey-darker border-0 rounded text-center form-control w-44 my-0.5"
                                name="valor_minimo[]" value="{{ $registro->valor_minimo }}"></td>
                        <td><input type="text"
                                class="bg-grey-darker border-0 rounded text-center form-control w-44 my-0.5"
                                name="valor_maximo[]" value="{{ $registro->valor_maximo }}"></td>
                        <td><input type="text"
                                class="bg-grey-darker border-0 rounded text-center form-control w-44 my-0.5"
                                name="indice[]" value="{{ $registro->indice }}"></td>
                        <td><input type="text"
                                class="bg-grey-darker border-0 rounded text-center form-control w-44 my-0.5"
                                name="fator_redutor[]" value="{{ $registro->fator_redutor }}"></td>
                        <td><input type="text"
                                class="bg-grey-darker border-0 rounded text-center form-control w-44 my-0.5"
                                name="iss_retido_das[]" value="{{ $registro->iss_retido_das }}"></td>
                        <td>
                            <a href="#" id="remove-row" class="relative right-2">
                                <svg width="29" height="29" viewBox="0 0 29 29" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.0501 2.90002C12.7809 2.90017 12.517 2.97525 12.2881 3.11688C12.0591 3.2585 11.8741 3.46106 11.7538 3.70187L10.704 5.80002H5.8001C5.41553 5.80002 5.04672 5.95279 4.77479 6.22472C4.50287 6.49665 4.3501 6.86546 4.3501 7.25002C4.3501 7.63459 4.50287 8.0034 4.77479 8.27533C5.04672 8.54726 5.41553 8.70002 5.8001 8.70002V23.2C5.8001 23.9692 6.10563 24.7068 6.64949 25.2506C7.19334 25.7945 7.93097 26.1 8.7001 26.1H20.3001C21.0692 26.1 21.8069 25.7945 22.3507 25.2506C22.8946 24.7068 23.2001 23.9692 23.2001 23.2V8.70002C23.5847 8.70002 23.9535 8.54726 24.2254 8.27533C24.4973 8.0034 24.6501 7.63459 24.6501 7.25002C24.6501 6.86546 24.4973 6.49665 24.2254 6.22472C23.9535 5.95279 23.5847 5.80002 23.2001 5.80002H18.2962L17.2464 3.70187C17.1261 3.46106 16.9411 3.2585 16.7121 3.11688C16.4832 2.97525 16.2193 2.90017 15.9501 2.90002H13.0501ZM10.1501 11.6C10.1501 11.2155 10.3029 10.8466 10.5748 10.5747C10.8467 10.3028 11.2155 10.15 11.6001 10.15C11.9847 10.15 12.3535 10.3028 12.6254 10.5747C12.8973 10.8466 13.0501 11.2155 13.0501 11.6V20.3C13.0501 20.6846 12.8973 21.0534 12.6254 21.3253C12.3535 21.5973 11.9847 21.75 11.6001 21.75C11.2155 21.75 10.8467 21.5973 10.5748 21.3253C10.3029 21.0534 10.1501 20.6846 10.1501 20.3V11.6ZM17.4001 10.15C17.0155 10.15 16.6467 10.3028 16.3748 10.5747C16.1029 10.8466 15.9501 11.2155 15.9501 11.6V20.3C15.9501 20.6846 16.1029 21.0534 16.3748 21.3253C16.6467 21.5973 17.0155 21.75 17.4001 21.75C17.7847 21.75 18.1535 21.5973 18.4254 21.3253C18.6973 21.0534 18.8501 20.6846 18.8501 20.3V11.6C18.8501 11.2155 18.6973 10.8466 18.4254 10.5747C18.1535 10.3028 17.7847 10.15 17.4001 10.15Z"
                                        fill="#6B7280" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
        <div class="flex justify-between items-center mt-4">
            <div class="flex-start bg-green-500 rounded py-2 px-4 text-white hover:bg-green-600">
                <a href="#" id="add-row">Adicionar</a>
            </div>

            <div class="flex-end">
                <x-button type="submit" class="clear-both">Salvar</x-button>
            </div>
        </div>
    </form>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function() {
        let idRow;
        let tableLength = 0;
        $('#add-row').on('click', function() {
            idRow = parseInt($('table tr:last').attr('id')) + 1;
            const row =
                '<tr id=' + idRow + '>' +
                '<td><input type="text" class="bg-grey-darker border-0 rounded text-center form-control w-44 my-0.5" name="valor_minimo[]"></td>' +
                '<td><input type="text" class="bg-grey-darker border-0 rounded text-center form-control w-44 my-0.5" name="valor_maximo[]"></td>' +
                '<td><input type="text" class="bg-grey-darker border-0 rounded text-center form-control w-44 my-0.5" name="indice[]"></td>' +
                '<td><input type="text" class="bg-grey-darker border-0 rounded text-center form-control w-44 my-0.5" name="fator_redutor[]"></td>' +
                '<td><input type="text" class="bg-grey-darker border-0 rounded text-center form-control w-44 my-0.5" name="iss_retido_das[]"></td>' +
                '<td><a href="#" id="remove-row" class=""><svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.0501 2.90002C12.7809 2.90017 12.517 2.97525 12.2881 3.11688C12.0591 3.2585 11.8741 3.46106 11.7538 3.70187L10.704 5.80002H5.8001C5.41553 5.80002 5.04672 5.95279 4.77479 6.22472C4.50287 6.49665 4.3501 6.86546 4.3501 7.25002C4.3501 7.63459 4.50287 8.0034 4.77479 8.27533C5.04672 8.54726 5.41553 8.70002 5.8001 8.70002V23.2C5.8001 23.9692 6.10563 24.7068 6.64949 25.2506C7.19334 25.7945 7.93097 26.1 8.7001 26.1H20.3001C21.0692 26.1 21.8069 25.7945 22.3507 25.2506C22.8946 24.7068 23.2001 23.9692 23.2001 23.2V8.70002C23.5847 8.70002 23.9535 8.54726 24.2254 8.27533C24.4973 8.0034 24.6501 7.63459 24.6501 7.25002C24.6501 6.86546 24.4973 6.49665 24.2254 6.22472C23.9535 5.95279 23.5847 5.80002 23.2001 5.80002H18.2962L17.2464 3.70187C17.1261 3.46106 16.9411 3.2585 16.7121 3.11688C16.4832 2.97525 16.2193 2.90017 15.9501 2.90002H13.0501ZM10.1501 11.6C10.1501 11.2155 10.3029 10.8466 10.5748 10.5747C10.8467 10.3028 11.2155 10.15 11.6001 10.15C11.9847 10.15 12.3535 10.3028 12.6254 10.5747C12.8973 10.8466 13.0501 11.2155 13.0501 11.6V20.3C13.0501 20.6846 12.8973 21.0534 12.6254 21.3253C12.3535 21.5973 11.9847 21.75 11.6001 21.75C11.2155 21.75 10.8467 21.5973 10.5748 21.3253C10.3029 21.0534 10.1501 20.6846 10.1501 20.3V11.6ZM17.4001 10.15C17.0155 10.15 16.6467 10.3028 16.3748 10.5747C16.1029 10.8466 15.9501 11.2155 15.9501 11.6V20.3C15.9501 20.6846 16.1029 21.0534 16.3748 21.3253C16.6467 21.5973 17.0155 21.75 17.4001 21.75C17.7847 21.75 18.1535 21.5973 18.4254 21.3253C18.6973 21.0534 18.8501 20.6846 18.8501 20.3V11.6C18.8501 11.2155 18.6973 10.8466 18.4254 10.5747C18.1535 10.3028 17.7847 10.15 17.4001 10.15Z" fill="#6B7280"/></svg></a></td>' +
                +'</tr>';

            $('tbody').append(row);
        });

        $(document).on('click', '#remove-row', function() {
            let rowIdToRemove = $(this).closest('tr').attr("id");
            $('#' + rowIdToRemove).remove();
            deleteItem(rowIdToRemove);
        });

        function deleteItem(id) {
            let url = '{{ route('formulas.removerEntrada') }}';
            let alertBox = $('#alert');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: url,
                data: {
                    id: id
                },
                success: function(result) {
                    if (result.type == 'sucess') {
                        alertBox.addClass('bg-alert-sucess');
                        alertBox.find('div').text(result.message);
                        alertBox.removeClass('hidden');
                        alertBox.fadeOut(6000);
                    }
                },
                error: function(result) {
                    const response = result.responseJSON;
                    alertBox.addClass('bg-alert-error');
                    alertBox.find('div').text(response.message);
                    alertBox.removeClass('hidden');
                    alertBox.fadeOut(6000);
                }
            });
        }
    });
</script>
