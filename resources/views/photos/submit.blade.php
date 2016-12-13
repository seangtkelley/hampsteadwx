@extends('layouts.master')

@section('title', 'Photos')

@section('navbar-type', 'static-top')


@section('content')

<div class="container" style="min-height: 650px;">
  <form action="{{route('photos.submit')}}" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <h2>Upload Photo</h2>

    <script>

    </script>
    <div class="row better-row">

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Photo:</h4></div>
      <input class="col-xs-12 col-sm-12 col-md-4 col-lg-4" type="file" name="image" />
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;" ></div>


      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Caption:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <textarea rows="2" cols="75" name="caption" class="form-control"></textarea>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 60px;"></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"><h4>Password:</h4></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="min-height: 40px;">
        <input type="password" name="password" class="form-control" placeholder="Enter Password" />
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;" ></div>

      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="min-height: 40px;"></div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
        <input type="submit" name="submit" id="submit" class="btn btn-success" style="width: 100%" value="Upload Photo" />
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="min-height: 40px;"></div>

    </div>
  </form>
</div>

@endsection
