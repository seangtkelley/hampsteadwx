@extends('layouts.master')

@section('title', 'Home')

@section('navbar-type', 'fixed-top')


@section('content')
  <div class="container" style="min-height: 500px;">
    <script>
      $(document).ready(function() {
        $(".monthSelect").select2({
          placeholder: "Select a Month",
          allowClear: true
        });
        $(".yearSelect").select2({
          placeholder: "Select a Year",
          allowClear: true
        });
      });
    </script>
    <div class="row betterRow">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <select class="monthSelect" multiple="multiple" style="width: 100%">
          <option value="1">January</option>
          <option value="2">February</option>
          <option value="3">March</option>
          <option value="4">April</option>
          <option value="5">May</option>
          <option value="6">June</option>
          <option value="7">July</option>
          <option value="8">August</option>
          <option value="9">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <select class="yearSelect" multiple="multiple" style="width: 100%">
          <option value="2011">2011</option>
          <option value="2012">2012</option>
          <option value="2013">2013</option>
          <option value="2014">2014</option>
          <option value="2015">2015</option>
        </select>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <input type="button" id="find" class="btn btn-success" style="width: 100%" value="Find Summary" />
      </div>
    </div>
  </div>
@endsection
