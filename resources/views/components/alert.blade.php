@if (isset($message) && isset($type))
    <div class="alert absolute px-6 top-5\5 text-sm right-2.5 w-66 h-14 bg-alert-{{ $type }} text-white rounded-lg text-center"
        id="alert">
        <div class="flex w-full h-full items-center justify-center">
            {{ $message }}
            <x-svg.check />
        </div>
    </div>

    <script>
        $('#alert').click(function() {
            $(this).fadeOut(6500)
        })
        $('#alert').click()
    </script>
@endif
