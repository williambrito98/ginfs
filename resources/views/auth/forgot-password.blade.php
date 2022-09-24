<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section class="h-full flex justify-center items-center flex-col">
        <div class="container-login">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="">
            </div>
            <div class="mt-4">
                <span class="font-bold text-lg text-white">Insira seu e-mail</span>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <input
                        class="block w-full my-3 p-2 border-2 rounded @error('email') border-red-500 @enderror focus:outline-none focus:shadow-outline"
                        name="email" type="email">
                    @error('email')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                    <button
                        class="mb-4 mt-8 font-bold w-full float-right mt-4 bg-btn-yellow px-10 py-1 rounded hover:bg-yellow-600">Recuperar senha
                    </button>                    
                </form>

                <a href="{{ route('login') }}" class="text-yellow-custom-login text-sm">Login</a>
            </div>
        </div>
    </section>
</x-guest-layout>

