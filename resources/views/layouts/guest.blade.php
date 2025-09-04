<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://github.com/developershu/proyectimages/blob/main/favicon_color.png?raw=true"
        type="image/x-icon">

    <title>Doc Junta Directiva</title>

    

    <!-- Tailwind CSS (Directo desde CDN para evitar problemas con Vite en esta vista) -->
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/sass/app.scss'])

    
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background-color: #003764;">

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg- shadow overflow-hidden sm:rounded-lg" style="background-color: #003764;">
            <div class="flex justify-center mb-4">
                <img src="http://172.22.118.101:81/proyectsImages/logo_documentacion.png"
                    alt="Logo de la Empresa" class="h-26 w-26 img-fluid" >
            </div>
            @yield('content')
        </div>
    </div>
    <!-- Bootstrap JS Bundle con Popper 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>-->

    @stack('scripts')
</body>

</html>
