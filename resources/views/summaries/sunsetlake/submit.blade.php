@extends('layouts.master')

@section('title', 'Sunset Lake Ice In/Ice Out')

@section('navbar-type', 'fixed-top')


@section('content')

<div class="container">
  <form action="{{route('sunsetlake.submit')}}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <h2>Submit Sunset Lake Ice In/Ice Out</h2>

    <script>
      $(document).ready(function() {
        $( "#icein" ).datepicker();
        $( "#iceout" ).datepicker();
        $(".seasonSelect").select2({
          placeholder: "Select a Season"
        });
      });
    </script>

    <div class="row better-row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Season:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <select class="seasonSelect" name="season" style="width: 100%">
          <option value="2011-2012">2011-2012</option>
          <option value="2012-2013">2012-2013</option>
          <option value="2013-2014">2013-2014</option>
          <option value="2014-2015">2014-2015</option>
          <option value="2015-2016">2015-2016</option>
          <option value="2016-2017">2016-2017</option>
        </select>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;"></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Ice In:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <input type="text" id="icein" name="icein" class="form-control">
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;"></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Ice Out:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <input type="text" id="iceout" name="iceout" class="form-control">
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;"></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Password:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="min-height: 40px;">
        <input type="password" name="password" class="form-control" placeholder="Enter Password" />
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;" ></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <input type="submit" name="submit" id="submit" class="btn btn-success" style="width: 100%" value="Submit Ice In/Ice Out" />
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;"></div>

    </div>
  </form>
</div>

@endsection
