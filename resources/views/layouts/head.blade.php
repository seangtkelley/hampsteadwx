<title>@yield('title') - Hampstead WX</title>
<meta name="google-site-verification" content="eHuJnDa5CqkSV4STXkOD9ugovArggyqdT4wYUt5bq8I" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link href="{{asset('css/app.css', true)}}" rel="stylesheet" type="text/css">
<script src="{{asset('js/app.js', true)}}"></script>
<script>
    $( document ).ready(function() {
        $("#alerts").width($(window).width());

        $( window ).resize(function() {
            $("#alerts").width($(window).width());
        });
    });
</script>
