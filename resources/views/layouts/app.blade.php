<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="https://github.com/developershu/proyectimages/blob/main/favicon_color.png?raw=true" type="image/x-icon">

    <title>Doc Junta Directiva</title>
    
    
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

   <link href="https://cdn.tailwindcss.com" rel="stylesheet"></link>
    

     
    
    @stack('styles')
</head>
<body>
    <div id="app">
        {{-- Barra de Navegación --}}
        <nav class="navbar navbar-expand-md navbar-dark  shadow-sm" style="background-color: #003764;"> ">
            <div class="container">
                
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- Menú Principal --}}
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('documentos.index') }}">Documentos</a>
                            </li>
                            @can('admin-access')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('documentos.create') }}">Nuevo Documento</a>
                            </li>
                            @endcan
                        @endauth
                    </ul>

                    {{-- Menú de Usuario --}}
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" 
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li> Esto es para poder editar los perfiles de usuarios
                                    <li><hr class="dropdown-divider"></li>-->
                                    <li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Contenido Principal --}}
        <main class="py-4">
            
            <div class="container">
                @include('partials.alerts')
                @yield('content')
            </div>
        </main>
    </div>

   {{-- Bootstrap JS Bundle con Popper --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>