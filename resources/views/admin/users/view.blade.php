<x-app-layout>

    <x-title title="Meu perfil" />
    <hr class="mb-3">

    <section class="container mx-auto bg-table rounded-xl">
        <div class="text-center bg-grey-darker py-2.5 rounded-t-xl">
            <h3 class="text-5C5C5C">MEUS DADOS</a>
        </div>

        <form action="{{ route('usuarios.updateProfile', $user->id) }}" method="POST" class="max-w-screen-md mx-auto">
            @csrf
            <div>
                <div>
                    <x-form.label value="NOME" />
                    <x-form.input type="text" name="nome" value="{{ $user->name ?? old('nome') }}" required
                        class="rounded w-full" maxlength="10"/>
                </div>
                <div>
                    <x-form.label value="E-MAIL " />
                    <x-form.input type="email" name="email" value="{{ $user->email ?? old('email') }}" required
                        class="rounded w-full" />
                </div>
            
            </div>
            <x-button type="submit">Salvar</x-button>
        </form>

        <script>
            $('body > main > section > form > button').click(e => {
                e.preventDefault()
                let password = $('#password').val()
                let checkPassword = $('#checkPassword').val()
                if (password !== checkPassword) {
                    alert('O campo de confirmação de senha deve ser igual ao campo da senha')
                    return
                }
                e.target.form.submit()
            })
        </script>

    </section>
</x-app-layout>
