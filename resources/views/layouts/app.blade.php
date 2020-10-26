<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        /* Modify the backgorund color */
        .barra-cinza{
            background-color: #D3D3D3;
        }

        .barra-cinza li a{
            color: black;
        }

        .barra-cinza li:hover{
            background-color: #C4C4C4;
        }

        .barra-cinza-escuro{
            background-color: #C4C4C4;
            height: 100px;
            margin-right: -16px;
        }

        .remover-margin{
            margin-left: -16px;
            margin-top: -16px;
            margin-bottom: -16px;

        }


        .nav {
            height: calc(100vh - 100px);
        }


    </style>
</head>
<body class="bg-white">
    <div id="app" >
        <nav class="navbar navbar-expand-md navbar-light barra-cinza-escuro shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="modal-body row navbar-expand-m">
            @if(isset(Auth::user()->servidor))
                <div class="col-md-2 remover-margin">
                    <ul class="nav navbar-nav flex-column barra-cinza text-center">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('pedido.criar')}}">Pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Solicitar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Histórico</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('servidor.editar')}}">Perfil</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-10">
                    <main >
                        @yield('content')
                    </main>
                </div>
            @elseif(isset(Auth::user()->funcionario))
            <div class="col-md-2 remover-margin">
                <ul class="nav navbar-nav flex-column barra-cinza text-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('pedido.listar')}}">Histórico</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('funcionario.editar')}}">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('listarEquipamentos')}}">Estoque</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('funcionario.lista.servidor')}}">Servidores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('funcionario.lista.funcionario')}}">Funcionários</a>
                    </li>
                </ul>
                </div>

                <div class="col-md-10">
                    <main >
                        @yield('content')
                    </main>
                </div>
            @else
                <div class="col-md-12">
                    <main >
                        @yield('content')
                    </main>
                </div>
            @endif



        </div>



    </div>
</body>
</html>

