<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#10b981">
    <title>@yield('title', 'Acceso | Presente')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="m-0 min-h-screen bg-[#f6faf8] text-slate-800 antialiased">
    <main class="min-h-screen">
        @yield('content')
    </main>
</body>
</html>

