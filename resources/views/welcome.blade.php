@extends('layouts.master')

@section('title', 'Home')

@section('navbar-type', 'fixed-top')


@section('content')
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
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
@endsection
