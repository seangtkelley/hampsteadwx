@extends('layouts.master')

@section('title', 'Create Annual Summary')

@section('navbar-type', 'fixed-top')


@section('content')
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.js"></script>
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image-ios.js"></script>
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image-orientation.js"></script>
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image-meta.js"></script>
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image-exif.js"></script>
  <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image-exif-map.js"></script>
  <div class="container">
    <form action="{{route('summaries.annual.submit')}}" enctype="multipart/form-data" method="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <h2>Create Annual Summary</h2>

      <script>
        $(document).ready(function() {
          $(".monthSelect").select2({
            placeholder: "Select a Month"
          });
          $(".yearSelect").select2({
            placeholder: "Select a Year"
          });
        });
      </script>
      <div class="row betterRow">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 30px;"><h4>Year:</h4></div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 30px;"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
          <select class="yearSelect" name="year" style="width: 100%">
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
          </select>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 30px;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 30px;"><h4>Password:</h4></div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 30px;"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="min-height: 30px;">
          <input type="password" name="password" class="form-control" placeholder="Enter Password" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 30px;" ></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 30px;"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
          <input type="submit" name="submit" id="submit" class="btn btn-success" style="width: 100%" value="Calculate Summary" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="min-height: 30px;"></div>

      </div>
    </form>
  </div>
@endsection
