@extends('layouts.master')

@section('title', 'Weather Events')

@section('navbar-type', 'fixed-top')


@section('content')

<div class="container" style="min-height: 650px;">
  <form action="{{route('events.submit')}}" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <h2>Submit Weather Event</h2>

    <script>
      $(document).ready(function() {
        $(".type").select2({
          placeholder: "Select a Type",
          allowClear: true
        });
        $('.type').val('').trigger('change');
        $( "#startDate" ).datepicker();
        $( "#endDate" ).datepicker();
      });
    </script>

    <div class="row betterRow">

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Type:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <input type="text" name="type" id="type" class="form-control" style="width: 100%" />
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;" ></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Start Date:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <input type="text" id="startDate" name="startDate" class="form-control">
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;"></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>End Date:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <input type="text" id="endDate" name="endDate" class="form-control">
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;"></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Description:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <textarea rows="4" cols="75" name="caption" class="form-control"></textarea>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 100px;"></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Password:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="min-height: 40px;">
        <input type="password" name="password" class="form-control" placeholder="Enter Password" />
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;" ></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <input type="submit" name="submit" id="submit" class="btn btn-success" style="width: 100%" value="Submit Event" />
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;"></div>

    </div>
  </form>
</div>

@endsection
