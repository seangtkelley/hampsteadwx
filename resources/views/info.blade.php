@extends('layouts.master')

@section('title', 'Info')

@section('navbar-type', 'fixed-top')


@section('content')

<div class="container" style="min-height: 650px;">
  <h2>Station Information</h2>
  <div class="row better-row">
    <div class="col-md-3">
      <h4>Location:</h4>
    </div>
    <div class="col-md-9">
      <h4>West Hampstead, New Hampshire</h4>
    </div>

    <div class="col-md-3">
      <h4>Station SHEF ID:</h4>
    </div>
    <div class="col-md-9">
      <h4>HMPN3</h4>
    </div>

    <div class="col-md-3">
      <h4>Station Index Number:</h4>
    </div>
    <div class="col-md-9">
      <h4>27-9278-02</h4>
    </div>

    <div class="col-md-3">
      <h4>Latitude:</h4>
    </div>
    <div class="col-md-9">
      <h4>42.911 oN</h4>
    </div>

    <div class="col-md-3">
      <h4>Longitude:</h4>
    </div>
    <div class="col-md-9">
      <h4>72.201 oW</h4>
    </div>

    <div class="col-md-3">
      <h4>Elevation (ft):</h4>
    </div>
    <div class="col-md-9">
      <h4>300 MSL</h4>
    </div>

    <div class="col-md-3">
      <h4>Observation Time:</h4>
    </div>
    <div class="col-md-9">
      <h4>7 AM EST</h4>
    </div>

    <div class="col-md-3">
      <h4>Began Operations:</h4>
    </div>
    <div class="col-md-9">
      <h4>December 1, 2003</h4>
    </div>

    <div class="col-md-3">
      <h4>Supervising WFO:</h4>
    </div>
    <div class="col-md-9">
      <h4>NWS WFO Gray, ME</h4>
    </div>

  </div>
</div>

@endsection
