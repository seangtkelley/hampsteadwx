<div id="navbar">
    <nav class="navbar navbar-default navbar-@yield('navbar-type')">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a id="navBrand" class="navbar-brand" href="/" style="position: relative; top: -10px; width: 150px;">
                    <img alt="NOAA" width="40" height="40" src="{{asset('img/NOAA.gif', true)}}" style="margin-right:0px; display: inline;" />
                    <img alt="NWS" width="40" height="40" src="{{asset('img/NWS.png', true)}}" style="margin-right:0px; display: inline;"  />
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <p class="navbar-text">Cooperative Climatological Station, West Hampstead, NH</p>
              <ul class="nav navbar-nav navbar-right navElement">

                <li class="dropdown navElement">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Observations <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#">Profile</a></li>
                      <li><a href="#">Projects</a></li>
                      <li><a href="#">Settings</a></li>
                      <li role="separator" class="divider"></li>
                      <li><a href="/logout">Logout</a></li>
                  </ul>
                </li>

                <li class="dropdown navElement">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Summaries <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#">Profile</a></li>
                      <li><a href="#">Projects</a></li>
                      <li><a href="#">Settings</a></li>
                      <li role="separator" class="divider"></li>
                      <li><a href="/logout">Logout</a></li>
                  </ul>
                </li>

                <li class="dropdown navElement">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Events <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#">Profile</a></li>
                      <li><a href="#">Projects</a></li>
                      <li><a href="#">Settings</a></li>
                      <li role="separator" class="divider"></li>
                      <li><a href="/logout">Logout</a></li>
                  </ul>
                </li>

                <li class="dropdown navElement">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Normals <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#">Profile</a></li>
                      <li><a href="#">Projects</a></li>
                      <li><a href="#">Settings</a></li>
                      <li role="separator" class="divider"></li>
                      <li><a href="/logout">Logout</a></li>
                  </ul>
                </li>

                <li><a href="#">Info</a></li>

                <li class="dropdown navElement">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Photos <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#">Profile</a></li>
                      <li><a href="#">Projects</a></li>
                      <li><a href="#">Settings</a></li>
                      <li role="separator" class="divider"></li>
                      <li><a href="/logout">Logout</a></li>
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
