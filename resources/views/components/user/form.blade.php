@props(['message', 'user', 'action', 'method', 'roles'])

<form action={{ $action }} method="POST" class="max-w-screen-md mx-auto">
    @csrf
    {{ $method ?? '' }}
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
        <div class="flex justify-between">
            @if (!isset($user))
            <div class="w-60">
                <x-form.label value="SENHA " />
                <x-form.input type="password" name="password" id="password"
                    value="{{ old('password') }}" required
                    class="w-full rounded" />
            </div>
            @endif
            @if (!isset($user))
            <div class="w-60">
                <x-form.label value="CONFIRMAR SENHA " />
                <x-form.input type="password" name="checkPassword" id="checkPassword"
                    required value="{{ old('password') }}"
                    class="w-full rounded" />
            </div>
            @endif
            <div class="w-60">
                <x-form.label value="CARGO" /><br>
                <select name="role_id" id="roles"
                    class="w-full rounded border-input focus:border-yellow-400 focus:ring-yellow-200">
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
    <x-button type="submit">Salvar</x-button>
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
