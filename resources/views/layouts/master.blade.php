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

    <title>{{ config('app.name', 'Vue App') }}</title>
    <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">
</head>

<body class="hold-transition sidebar-mini">
  <div id="app">
    <div class="wrapper">
        <!--TOp Navbar -->
        @include('layouts.topNavbar')
        <!-- Top /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.sidebar')
        {{-- End Main Sidebar Container --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <div class="content">
            <div class="container-fluid">
              <router-view></router-view>
              <vue-progress-bar></vue-progress-bar>

            </div>
          </div>
        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer -->
        @include('layouts.footer')
        {{-- END Main Footer --}}
    </div>
    <!-- ./wrapper -->

  </div>
    <!-- REQUIRED SCRIPTS -->

    <script src="{{ asset('public/js/app.js') }}"></script>
</body>

</html>
