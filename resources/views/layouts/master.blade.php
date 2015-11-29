<?php require_once(app_path('Listeners/AlertListener.php')); ?>
<html>
    <head>
      @section('head')
        @include('layouts.head')
      @show
    </head>
    <body>
        @section('navbar')
            @include('layouts.navbar')
        @show

        @section('alerts')
            @include('layouts.alerts')
        @show

        <div id="main-content" class="">
            @yield('content')
        </div>

        @section('footer')
          @include('layouts.footer')
        @show
    </body>
</html>
