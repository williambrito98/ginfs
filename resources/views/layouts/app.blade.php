<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script defer src="{{ asset('js/dropDownMenu.js') }}"></script>

</head>

<body>
    <header class="max-w-full p-4 bg-black">
        <nav class="">
            <ul class="flex justify-between items-center flex-wrap">
                <li>
                    <a href="{{ route('clientes.index') }}">
                        <img src={{ asset('images/logo.png') }} class="logo_header" alt="">
                    </a>
                </li>
                <li>
                    <a href="{{ route('solicitacao.create') }}"
                        class="bg-btn-header-yellow px-8 py-2 rounded-sm hover:bg-yellow-300">
                        SOLICITAR NOTA FISCAL</a>
                </li>
                <li class="cursor-pointer">
                    <div class="menu-main rounded-full relative flex justify-between items-center bg-btn-dropdown-client py-0.5 hover:bg-gray-400 transition"
                        id="menu">
                        <div class="mx-0.5">
                            <x-svg.userCircleOutline />
                        </div>
                        <div>
                            <p class="text-sm">{{ \Auth::user()->name }}</p>
                        </div>
                        <div class="mx-2 animate-bounce">
                            <x-svg.chevronDown />
                        </div>
                        <div class="absolute hidden top-9 border transition rounded-lg bg-table w-full h-auto z-50"
                            id="sub-menu">
                            <ul class="text-center rounded-lg">
                                    <li class="p-2 text-sm rounded-t-md hover:bg-gray-400 transition">
                                        <a href="{{ route('usuarios.show', \Auth::user()->id) }}">Meu perfil</a>
                                    </li>
                                @can('ver-clientes')
                                    <li class="p-2 text-sm hover:bg-gray-400 transition">
                                        <a href="{{ route('clientes.index') }}">Clientes</a>
                                    </li>
                                @endcan
                                @can('ver-usuarios')
                                    <li class="p-2 text-sm hover:bg-gray-400 transition">
                                        <a href="{{ route('usuarios.index') }}">Usuarios</a>
                                    </li>
                                @endcan
                                @can('ver-tomadores')
                                    <li class="p-2 text-sm hover:bg-gray-400 transition">
                                        <a href="{{ route('tomadores.index') }}">Tomadores</a>
                                    </li>
                                @endcan
                                @can('ver-servicos')
                                    <li class="p-2 text-sm hover:bg-gray-400 transition">
                                        <a href="{{ route('servicos.index') }}">Serviços</a>
                                    </li>
                                @endcan
                                @can('ver-faturamento')
                                    <li class="p-2 text-sm hover:bg-gray-400 transition">Faturamento</li>
                                @endcan

                                @can('ver-formulas')
                                    <li class="p-2 text-sm hover:bg-gray-400 transition">Fórmulas</li>
                                @endcan
                                    <li class="p-2 text-sm rounded-b-md hover:bg-gray-400 transition">
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
    <main class="w-5/6 container mx-auto relative my-10">
        {{ $slot }}
    </main>
</body>

</html>
