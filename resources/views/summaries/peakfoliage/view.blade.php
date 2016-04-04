@extends('layouts.master')

@section('title', 'Peak Foliage')

@section('navbar-type', 'fixed-top')


@section('content')
  <div id="" class="container" style="min-height: 650px;">
    <h3>Peak Foliage</h3>
    <h3>NWS Cooperative Climatological Station, West Hampstead, New Hampshire</h3>
    County: Rockingham  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Town: Hampstead
    <br><br>
    <table class="table-bordered table-hover" style="min-width: 150px">
      <tbody>
        <tr>
          <th style="text-align: center;"><h4>Year</h4></th>
          <th style="text-align: center;"><h4>Date</h4></th>
        </tr>
        @foreach ($allPeaks as $peak)
          <tr>
            <th style="text-align: center;">{{ $peak->year }}</th>
            <th style="text-align: center;">{{ $peak->date }}</th>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
