<div id="navbar">
    <script>
    $(document).ready(function() {
      $( window ).resize(function() {
        if($( window ).width() < 1200){
          $(".navbar-text").html("");
        } else {
          $(".navbar-text").html("Cooperative Climatological Station, West Hampstead, NH");
        }
      });
    });
    </script>
    <nav class="navbar navbar-default navbar-@yield('navbar-type')" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="true">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a id="navBrand" class="navbar-brand" href="/" style="position: relative; top: -10px; width: 150px;">
                    <img alt="NOAA" width="40" height="40" src="{{asset('img/NOAA.gif')}}" style="margin-right:0px; display: inline;" />
                    <img alt="NWS" width="40" height="40" src="{{asset('img/NWS.png')}}" style="margin-right:0px; display: inline;"  />
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div  class="collapse navbar-collapse" id="navbar-collapse">
              <p class="navbar-text">Cooperative Climatological Station, West Hampstead, NH</p>
              <ul class="nav navbar-nav navbar-right navElement">

                <li class="dropdown navElement">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Observations <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="http://www.nws.noaa.gov/view/validProds.php?prod=HYD&amp;node=KGYX" target="_blank">Daily</a></li>
                    <li><a href="http://www.nohrsc.noaa.gov/interactive/html/graph.html?station=HMPN3" target="_blank">Weekly</a></li>
                    <li><a href="http://mesonet.agron.iastate.edu/sites/plot.php?prod=0&station=HMPN3&network=NH_COOP" target="_blank">Max/Min Temps for Past 7 Days</a></li>
                    <li><a href="http://mesonet.agron.iastate.edu/sites/plot.php?prod=1&station=HMPN3&network=NH_COOP" target="_blank">Max/Min Temps for Present Month</a></li>
                  </ul>
                </li>

                <li class="dropdown navElement">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Summaries <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="{{route('summaries.monthly.home')}}">Monthly</a></li>
                    <li><a href="{{route('summaries.annual.home')}}">Annual</a></li>
                    <li><a href="#">Snow Season</a></li>
                    <li><a href="#">Sunset Lake: Ice In/Ice Out</a></li>
                    <li><a href="#">Peak Foliage</a></li>
                    <li><a href="#">Seasonal Graphs</a></li>
                  </ul>
                </li>

                <li><a href="{{route('events.home')}}">Events</a></li>

                <li><a href="{{route('normals')}}">Normals</a></li>

                <li><a href="{{route('info')}}">Info</a></li>

                <li><a href="{{route('photos.home')}}">Photos</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
