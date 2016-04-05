@extends('layouts.master')

@section('title', 'Peak Foliage')

@section('navbar-type', 'fixed-top')


@section('content')
  <div id="" class="container" style="min-height: 650px;">
    <h3 style="text-align: center;">Peak Foliage</h3>
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
