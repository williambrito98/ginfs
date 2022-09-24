<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section class="h-full flex justify-center items-center flex-col">
        <div class="container-login">
            <div class="logo">
                <a href="https://uphold.com.br" target="_blank">
                    <img src="{{ asset('images/logo.svg') }}" alt="">
                </a>
            </div>
            <div class="mt-4">
                <span class="font-bold text-xl text-white">RECUPERAÇÃO DE SENHA</span>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="relative">
                        <input
                        class="block w-full my-3 p-2 border-2 rounded @error('email') border-red-500 @enderror border-yellow-200 focus:border-yellow-300 focus:ring-yellow-200 focus:outline-none focus:shadow-outline placeholder-gray-400"
                        name="email" type="email" placeholder="E-mail">
                        <div class="absolute right-3 top-3">
                            <x-svg.mail />
                        </div>
                    @error('email')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                    </div>

                    <button
                        class="mb-4 mt-8 font-bold w-full float-right mt-4 bg-btn-yellow px-10 py-1.5 rounded hover:bg-yellow-200">Enviar
                    </button>                    
                </form>

                <a href="{{ route('login') }}" class="text-yellow-custom-login text-xl border-effect">LOGIN</a>
               
            </div>
        </div>
    </section>
</x-guest-layout>

