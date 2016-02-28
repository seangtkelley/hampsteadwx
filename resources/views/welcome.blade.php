@extends('layouts.master')

@section('title', 'Home')

@section('navbar-type', 'fixed-top')


@section('content')
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img alt="NWS" src="{{asset('img/img_0736.jpg')}}" style="margin-right:0px; display: inline;"  />
      <div class="carousel-caption">
        <h2>Winter 2014</h2>
      </div>
    </div>
    <div class="item">
      <img alt="NWS" src="{{asset('img/100_0587.jpg')}}" style="margin-right:0px; display: inline;"  />
      <div class="carousel-caption">
        <h2>Spring 2008</h2>
      </div>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<div class="row betterRow">
  <!--<div class="col-md-1 col-lg-1">

  </div>-->
  <div class="col-md-12 col-lg-12" style="text-align: center; padding-left: 0px; padding-right: 0px">
    <div class="well" style="margin-bottom: 0px;">
      <h2 style="margin-top: 0px;">Related Sites</h2>
      <div class="row betterRow">
        <div class="col-md-1 col-lg-1"></div>
        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2" style="text-align: center">
          <a href="http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=KNHHAMPS5">
            <h4>Hampstead Fire Dept. Weather Station</h4>
            <img src="http://www.hampsteadnh.us/pages/HampsteadNH_Fire/firepatch" style="height: 100px; width: 100px"/>
          </a>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
          <a href="http://www.weatherlink.com/user/hmsweather/">
            <h4>Hampstead Middle School Weather Station</h4>
            <img src="{{asset('img/HMS_logo.png')}}" style="border-radius: 50%; height: 100px; width: 100px"/>
          </a>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
          <a href="http://www.weatherlink.com/user/hampsteadcentral/">
            <h4>Hampstead Central School Weather Station</h4>
            <img src="{{asset('img/HCS_logo.png')}}" style="border-radius: 50%; height: 100px; width: 100px"/>
          </a>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
          <a href="http://waterdata.usgs.gov/nwis/uv/?site_no=01100505">
            <h4>North Salem USGS Rain Gauge</h4><br>
            <img src="http://waterdata.usgs.gov/nwisweb/icons/USGS_header_graphic_usgsIdentifier_white.jpg"/>
          </a>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
          <a href="http://waterdata.usgs.gov/nwis/uv/?site_no=010735562">
            <h4>Sandown USGS Rain Gauge</h4><br>
            <img src="http://waterdata.usgs.gov/nwisweb/icons/USGS_header_graphic_usgsIdentifier_white.jpg"/>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!--<div class="col-md-1 col-lg-1">

  </div>-->
</div>

@endsection
