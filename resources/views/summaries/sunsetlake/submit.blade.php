@extends('layouts.master')

@section('title', 'Sunset Lake Ice In/Ice Out')

@section('navbar-type', 'static-top')


@section('content')

<div class="container">
  <form action="{{route('summaries.sunsetlake.submit')}}" method="POST">
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
          <?php
            for($i = 2011; $i <= date("Y"); $i++){
              echo "<option value=\"" . $i . "-" . strval($i+1) . "\">" . $i . "-" . strval($i+1) . "</option>";
            }
          ?>
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
