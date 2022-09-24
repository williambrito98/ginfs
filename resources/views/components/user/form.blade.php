@props(['message', 'user', 'action', 'method', 'roles'])

<form action={{ $action }} method="POST" class="max-w-screen-md mx-auto">
    @csrf
    {{ $method ?? '' }}
    <div class="mt-7">
        <div class="my-6">
            <input type="text" name="nome" placeholder="Nome" value="{{ $user->name ?? old('nome') }}" required
                class="w-full @error('nome') border-2 border-error @enderror border-yellow-400">
            @error('nome')
                <p> {{ $message }} </p>
            @enderror
        </div>
        <div class="my-6">
            <input type="email" name="email" placeholder="Email" value="{{ $user->email ?? old('email') }}" required
                class="w-full @error('email') border-2 border-error @enderror border-yellow-400">
            @error('email')
                <p> {{ $message }} </p>
            @enderror
        </div>
        <div class="my-6 flex justify-between">
            @if (!isset($user))
                <div>
                    <input type="password" name="password" id="password" placeholder="Senha"
                        value="{{ old('password') }}" required
                        class="@error('password') border-2 border-error @enderror border-yellow-400">
                    @error('password')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
            @endif
            @if (!isset($user))
                <div>
                    <input type="password" name="checkPassword" id="checkPassword" placeholder="Confirmar Senha"
                        required value="{{ old('password') }}"
                        class="@error('password') border-2 border-error @enderror border-yellow-400">
                    @error('password')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
            @endif
            <div>
                <select name="role_id" id="roles"
                    class="@error('role_id') border-2 border-error @enderror border-yellow-400">
                    @if (!old('role_id') && !isset($user))
                        <option selected>Selecione a função</option>
                    @else
                        <option>Selecione a função</option>
                    @endif

                    @foreach ($roles as $role)
                        @if (old('role_id') == $role->id)
                            <option selected value="{{ $role->id }}">{{ $role->nome }}</option>
                        @else
                            @if (isset($user))
                                @if ($role->id == $user->role?->id)
                                    <option selected value="{{ $role->id }}">{{ $role->nome }}
                                    </option>
                                @else
                                    <option value="{{ $role->id }}">{{ $role->nome }}</option>
                                @endif
                            @else
                                <option value="{{ $role->id }}">{{ $role->nome }}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
                @error('role_id')
                    <p>{{ $message }}</p>
                @enderror

                
            </div>

            
        </div>
    </div>
    <button type="submit"
        class="md:ml-auto lg:ml-auto xl:ml-auto bg-btn-yellow my-4  px-10 py-1 rounded hover:bg-yellow-600">Salvar</button>
</form>

@if (!isset($user))
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
@endif
