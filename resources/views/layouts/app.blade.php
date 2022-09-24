<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="/images/icon.ico">
        <title>Uphold - NFE</title>


        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

        <!-- Scripts -->
        <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.js') }}"></script>
        <script src="{{ asset('js/jquery.mask.js') }}"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script defer src="{{ asset('js/dropDownMenu.js') }}"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js%22%3E"></script>
    </head>

    <body>
        <header class="max-w-full p-4 bg-black">
            <nav class="">
                <ul class="flex justify-between items-center flex-wrap">
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <img src={{ asset('images/logo.svg') }} class="logo_header" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('solicitacao.create') }}"
                            class="bg-btn-yellow px-8 py-2 rounded-sm hover:bg-yellow-200">
                            SOLICITAR NOTA FISCAL</a>
                    </li>
                    <li class="cursor-pointer">
                        <div class="menu-main border border-white hover:bg-yellow-300 rounded-full relative flex justify-between items-center py-0.5 transition"
                            id="menu">
                            <div class="mx-0.5">
                                <x-svg.userCircleOutline />
                            </div>
                            <div>
                                <p class="text-sm text-white font-bold">{{ \Auth::user()->name }}</p>
                            </div>
                            <div class="mx-2 animate-bounce">
                                <x-svg.chevronDown />
                            </div>
                            <div class="absolute hidden top-9 border bg-black transition rounded-lg border border-white text-white w-full h-auto z-50"
                                id="sub-menu">
                                <ul class="text-center rounded-lg">
                                        <li class="p-2 text-sm hover:text-black hover:bg-yellow-300 transition rounded-t-md">
                                            <a href="{{ route('dashboard') }}">Dashboard</a>
                                        </li>
                                        <li class="p-2 text-sm hover:text-black hover:bg-yellow-300 transition">
                                            <a href="{{ route('solicitacao.index') }}">Solicitações</a>
                                        </li>
                                    @can('ver-clientes')
                                        <li class="p-2 text-sm hover:text-black hover:bg-yellow-300 transition">
                                            <a href="{{ route('clientes.index') }}">Clientes</a>
                                        </li>
                                    @endcan
                                    
                                    @can('ver-tomadores')
                                        <li class="p-2 text-sm hover:text-black hover:bg-yellow-300 transition">
                                            <a href="{{ route('tomadores.index') }}">Tomadores</a>
                                        </li>
                                    @endcan
                                    @can('ver-servicos')
                                        <li class="p-2 text-sm hover:text-black hover:bg-yellow-300 transition">
                                            <a href="{{ route('servicos.index') }}">Tipos de serviço</a>
                                        </li>
                                    @endcan
                                    <li class="p-2 text-sm hover:text-black hover:bg-yellow-300 transition">
                                        <a href="{{ route('fechamentomensal.index') }}">Fechamento mensal</a>
                                    </li>
                                    @can('ver-cidades')
                                        <li class="p-2 text-sm hover:text-black hover:bg-yellow-300 transition">
                                            <a href="{{ route('cidades.index') }}">Cidades</a>
                                        </li>
                                    @endcan
                                    @can('ver-formulas')
                                        <li class="p-2 text-sm hover:text-black hover:bg-yellow-300 transition">
                                            <a href="{{ route('formulas.index') }}">Fórmulas</a>
                                        </li>
                                    @endcan
                                    @can('ver-usuarios')
                                        <li class="p-2 text-sm hover:text-black hover:bg-yellow-300 transition">
                                            <a href="{{ route('usuarios.index') }}">Usuarios</a>
                                        </li>
                                    @endcan
                                        <li class="p-2 text-sm hover:text-black hover:bg-yellow-300 transition">
                                            <a href="{{ route('usuarios.show', \Auth::user()->id) }}">Meu perfil</a>
                                        </li>
                                        <li class="p-2 text-sm hover:text-black hover:bg-yellow-300 transition rounded-b-md">
                                            <a href="{{ route('logout') }}">Logout</a>
                                        </li>
                                </ul>
                            </div>
                        </div>

                    </li>
                </ul>
            </nav>

            <x-alert :message="Session::get('message')" :type="Session::get('type')" />
        </header>
        <!-- Page Content -->
        <main class="w-5/6 container mx-auto relative my-14">
            {{ $slot }}
        </main>
    </body>

</html>
