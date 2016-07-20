<title>@yield('title') - Hampstead WX</title>
<meta name="google-site-verification" content="eHuJnDa5CqkSV4STXkOD9ugovArggyqdT4wYUt5bq8I" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/addons.css')}}" rel="stylesheet" type="text/css">
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/locale/en-ca.js"></script>-->
<script src="{{asset('js/app.js')}}"></script>
<!--<script src="{{asset('js/ChartNew.js')}}"></script>-->
<script>
    $( document ).ready(function() {
        $("#alerts").width($("#main-content").width()*0.5).css("left", $("#main-content").width()*0.25);

        $( window ).resize(function() {
            $("#alerts").width($("#main-content").width()*0.5).css("left", $("#main-content").width()*0.25);
        });
    });
</script>
