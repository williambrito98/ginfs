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
                <span class="font-bold text-xl text-white">LOGIN</span>

                <form action="{{ route('validLogin') }}" method="POST">
                    @csrf
                    <div class="relative">
                        <input class="block w-full my-3 p-2 border-2 rounded @error('email') border-red-500 @enderror border-yellow-200 focus:border-yellow-300 focus:ring-yellow-200 focus:outline-none focus:shadow-outline placeholder-gray-400"
                        name="email" type="email" placeholder="E-mail">
                        <div class="absolute right-3 top-3">
                            <x-svg.user />
                        </div>
                    @error('email')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                    </div>

                    <div class="relative">
                        <input class="block w-full my-3 p-2 rounded border-2 @error('password') border-red-500 @enderror border-yellow-200 focus:border-yellow-300 focus:ring-yellow-200 focus:outline-none focus:shadow-outline placeholder-gray-400" name="password" type="password" name=""
                        placeholder="Senha">
                        <div class="absolute right-3 top-3">
                            <x-svg.lockClosed />
                        </div>
                    @error('password')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('password.request') }}"
                            class="text-yellow-custom-login font-medium">Esqueceu
                            sua
                            senha?</a>
                        <div class="flex justify-center items-center">
                            <div class="form-check">
                                <label class="form-check-label inline-block text-white" for="flexCheckDefault">
                                    Lembrar-me
                                </label>
                                <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-yellow-300 checked:border-yellow-300 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-right ml-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
                            </div>
                        </div>
                    </div>
                    <button
                        class="float-right mt-4 bg-btn-yellow px-10 py-1.5 rounded hover:bg-yellow-200 w-full font-bold">Entrar</button>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
