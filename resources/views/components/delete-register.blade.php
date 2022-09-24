@props(['route', 'userID'])

<form method="POST" class="opacity-25" id="deleteIcon" action="{{ $route }}"
    enctype="multipart/form-data">
    @csrf
    @method('DELETE')
    <input type="hidden" value="{{ $userID ?? '' }}" name="userID">
    <select name="idItens[]" id="itensToDelete" multiple class="hidden">
    </select>
    <button type="submit" id="deletar" class="flex items-center text-btns mt-4">
        <div class="inline-block">DELETAR</div>
        <div class="inline-block"><x-svg.trash /></div>
    </button>
</form>
<script defer>
    $(document).ready(() => {
        let ids = [];
        let select = $('#itensToDelete')
        $('#deletar').click(e => {
            e.preventDefault()
            if (ids.length) {
                ids.forEach(item => {
                    select.append(createOption(item))
                })
                $('#deleteIcon').submit()
            }
        })

        $('#selectAll').click(e => {
            let check = e.target.checked ? true : false
            $('body > main table tbody input').each(function() {
                if (check)
                    !ids.includes($(this).val()) ? ids.push($(this).val()) : ''
                else
                    ids.splice(ids.indexOf(e.target.value), 1)
                $(this).prop('checked', check)
            })
            if (check) {
                toggleForm()
            } else {
                toggleForm(true)
            }
        })

        $('.select').click(e => {
            if ($('#selectAll').prop('checked')) {
                $('#selectAll').prop('checked', false)
            }!ids.includes(e.target.value) ? ids.push(e.target.value) : ids.splice(ids.indexOf(e.target
                .value), 1)
            if (ids.length === 0) {
                toggleForm(true)
            } else {
                toggleForm()
            }
        })

        function toggleForm(disabled = false) {
            if (!disabled) {
                $('#deletar > button').prop('disabled', false)
                $('#deleteIcon').removeClass('opacity-25')
                return;
            }

            $('#deletar > button').prop('disabled', false)
            $('#deleteIcon').addClass('opacity-25')
            return;
        }

        function createOption(value) {
            let opt = $('<option></option>')
            opt.val(value)
            opt.prop('selected', true)
            return opt
        }

    })
</script>