<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- admin panel --}}

    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="{{ asset('assets/css/fontastic.css') }}">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('assets/css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}">

    {{-- swal --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">

    {{-- end admin panel --}}
    @stack('css')
</head>
<body>

    <div class="page">
      {{-- Main Navbar --}}
      @include('custom_layouts.admin.main-nav')
      {{-- End Main Navbar --}}
      <div class="page-content d-flex align-items-stretch">
        {{-- Side Navbar --}}
        @include('custom_layouts.admin.sidebar')
        {{-- End Side Navbar --}}
        <div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Dashboard</h2>
            </div>
          </header>
          <!-- Breadcrumb-->
          @yield('current-page')

          <section class="tables">
            <div class="container-fluid">
                @yield('main-content')
            </div>
          </section>
          <!-- Page Footer-->
          @include('custom_layouts.admin.footer')
        </div>
      </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    {{-- admin panel --}}
    <!-- JavaScript files-->
    <script src="{{ asset('assets/vendor/popper.js/umd/popper.min.js') }}"> </script>
    <script src="{{ asset('assets/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <!-- Main File-->
    <script src="{{ asset('assets/js/front.js') }}"></script>
    {{-- end admin panel --}}

    {{-- swal --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    @stack('js')
</body>
</html>
