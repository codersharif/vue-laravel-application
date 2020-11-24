<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vue App Login') }}</title>
    <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">
</head>

<body class="hold-transition login-page">
   @yield('login_content')
    <!-- jQuery -->
    <script src="{{ asset('public/js/app.js') }}"></script>

</body>

</html>
