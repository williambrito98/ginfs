@props(['route', 'userID', 'items', 'tomadorID', 'servicoID', 'roleID', 'placeholder'])
<div class="w-full">
    <div class="flex justify-between items-stretch ">
        <div class="w-11/12">
            <form action="{{ $route }}" method="POST">
            <div class="flex justify-between items-center ">
                <div class="w-10/12">
                    @csrf
                    <input type="hidden" name="idItem" id="idItem">
                    <input list="dataList" id="dataListInput" {{ $attributes->merge(['class' => 'border border-input py-2 rounded w-full px-4']) }}
                        placeholder="{{ $placeholder ?? '' }}">
                    <input type="hidden" name="tomador_id" value="{{ $tomadorID ?? '' }}">
                    <input type="hidden" name="user_id" value="{{ $userID ?? '' }}">
                    <datalist id="dataList">
                        @foreach ($items as $item)
                            <option data-value="{{ $item->id }}" value="{{ $item->nome }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="w-2/12 ml-2">
                    <x-button type="submit" id="submitDataList">Adicionar</x-button>
                </div>
            </div>
            </form>
        </div>
        <div class="w-1/12 mt-1">
            {{ $delete ?? " " }}
        </div>
    </div>
</div>

<script defer>
    $(document).ready(() => {
        $('#submitDataList').click((e) => {
            e.preventDefault()
            let input = $('#dataListInput').val()
            let dataValue = $("#dataList [value='" + input + "']").data('value')
            $('#idItem').val(dataValue)
            e.target.form.submit()
        })
    })
</script>
