<!DOCTYPE html>
<html lang="es">
<head>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href=" {{asset('assets/css/login_admin.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}"> --}}
    <link rel="icon" type="image/png" href="/logo-itslp.png">

    <title>Sistemea Escolar | Login</title>

</head>
<body>

    <main class="container">
        @yield('content')
    </main>
    
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>