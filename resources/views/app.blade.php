<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    <!-- Bootstrap 4.0.0 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ url('https://use.fontawesome.com/releases/v6.2.0/css/all.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/AdminLTE.min.css') }}">
    <!--Style datatable -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css') }}" />

    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/_all-skins.min.css') }}">

    <!-- Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="hold-transition skin-blue sidebar-mini">
    @inertia
</body>

</html>
