<html>
    <head>
      @section('head')
        @include('layouts.rawHead')
      @show
    </head>
    <body>

        <div class="container-fluid">
            @yield('content')
        </div>

    </body>
</html>
