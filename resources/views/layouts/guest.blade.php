<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://github.com/developershu/proyectimages/blob/main/favicon_color.png?raw=true"
        type="image/x-icon">

    <title>Doc Junta Directiva</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts: Montserrat-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Directo desde CDN para evitar problemas con Vite en esta vista) -->
    <script src="https://cdn.tailwindcss.com"></script>



    <!-- Estilos personalizados -->
    <style>
        .bg-fondo {
            background-color: #003764;
            /* Color de fondo */
        }

        .bg- {
            background-color: #003764;
            /* Color de fondo del contenedor */
        }

        .btn-login {
            background-color: #003764;
            border-color: #f7f7f7;
        }

        .btn-login:hover {
            background-color: #004b86;
            /* Un tono más claro al hacer hover */
            border-color: #ffffff;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-fondo">

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg- shadow overflow-hidden sm:rounded-lg">
            <div class="flex justify-center mb-4">
                <img src="https://github.com/developershu/proyectimages/blob/main/logo_documentacion.png?raw=true"
                    alt="Logo de la Empresa" class="h-26 w-26">
            </div>
            @yield('content')
        </div>
    </div>
    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
