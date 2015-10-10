<html>
    <head>
      @section('head')
        @include('layouts.head')
      @show
    </head>
    <body>

        <div class="container-fluid">
            @yield('content')
        </div>
        
    </body>
</html>
