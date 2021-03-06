@extends('layouts.master')

@section('title', 'Peak Foliage')

@section('navbar-type', 'static-top')


@section('content')

<div class="container">
  <form action="{{route('summaries.peakfoliage.submit')}}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <h2>Submit Peak Foliage</h2>

    <script>
      $(document).ready(function() {
        $( "#date" ).datepicker();
        $(".yearSelect").select2({
          placeholder: "Select a Year"
        });
      });
    </script>

    <div class="row better-row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Year:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <select class="yearSelect" name="year" style="width: 100%">
          <?php
            for($i = 2011; $i <= date("Y"); $i++){
              echo "<option value=\"" . $i . "\">" . $i . "</option>";
            }
          ?>
        </select>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;"></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Date:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <input type="text" id="date" name="date" class="form-control">
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;"></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Password:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="min-height: 40px;">
        <input type="password" name="password" class="form-control" placeholder="Enter Password" />
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;" ></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <input type="submit" name="submit" id="submit" class="btn btn-success" style="width: 100%" value="Submit Peak Foliage" />
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;"></div>

    </div>
  </form>
</div>

@endsection
