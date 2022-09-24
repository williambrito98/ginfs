<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section class="h-full flex justify-center items-center flex-col">
        <div class="container-login">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="">
            </div>
            <div class="mt-4">
                <span class="font-bold text-lg text-white">Login</span>

                <form action="{{ route('validLogin') }}" method="POST">
                    @csrf
                    <input
                        class="block w-full my-3 p-2 border-2 rounded @error('email') border-red-500 @enderror focus:outline-none focus:shadow-outline"
                        name="email" type="email" placeholder="Usuário">
                    @error('email')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                    <input class="block w-full my-3 p-2 rounded border-2 @error('email') border-red-500 @enderror focus:outline-none focus:shadow-outline" name="password" type="password" name=""
                        placeholder="Senha">
                    @error('password')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                    <div class="flex justify-between items-center">
                        <a href="{{ route('password.request') }}"
                            class="text-yellow-custom-login font-medium">Esqueceu
                            sua
                            senha?</a>
                        <div class="flex justify-center items-center">
                            <label class="text-white text-sm mr-2">Lembrar-me</label>
                            <input type="checkbox" name="remember">
                        </div>
                    </div>
                    <button
                        class="float-right mt-4 bg-btn-yellow px-10 py-1 rounded hover:bg-yellow-600">Entrar</button>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
