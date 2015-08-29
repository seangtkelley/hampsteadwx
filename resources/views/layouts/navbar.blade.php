<div id="navbar">
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
                    <li><a href="#">Daily</a></li>
                    <li><a href="#">Weekly</a></li>
                    <li><a href="#">Max/Min Temps for Past 7 Days</a></li>
                    <li><a href="#">Max/Min Temps for Present Month</a></li>
                  </ul>
                </li>

                <li class="dropdown navElement">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Summaries <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="{{route('monthlyDefault')}}">Montly</a></li>
                    <li><a href="#">Annual</a></li>
                    <li><a href="#">Snow Season</a></li>
                    <li><a href="#">Sunset Lake: Ice In/Ice Out</a></li>
                    <li><a href="#">Peak Foliage</a></li>
                    <li><a href="#">Seasonal Graphs</a></li>
                  </ul>
                </li>

                <li class="dropdown navElement">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Events <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Snow Storms</a></li>
                    <li><a href="#">Ice Storms</a></li>
                    <li><a href="#">Severe Thunderstorms</a></li>
                    <li><a href="#">Flooding</a></li>
                    <li><a href="#">Wind Storms</a></li>
                  </ul>
                </li>

                <li class="dropdown navElement">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Normals <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">All Normals</a></li>
                    <li><a href="#">Air Temperature</a></li>
                    <li><a href="#">Precipitation</a></li>
                    <li><a href="#">Heating/Cooling Degree Days</a></li>
                    <li><a href="#">Snowfall</a></li>
                  </ul>
                </li>

                <li><a href="#">Info</a></li>

                <li class="dropdown navElement">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Photos <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Winter</a></li>
                    <li><a href="#">Spring</a></li>
                    <li><a href="#">Summer</a></li>
                    <li><a href="#">Autumn</a></li>
                    <li><a href="#">Nearby Stations</a></li>
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
