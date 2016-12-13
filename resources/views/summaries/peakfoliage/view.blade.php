@extends('layouts.master')

@section('title', 'Peak Foliage')

@section('navbar-type', 'static-top')


@section('content')
  <div id="" class="container" style="min-height: 650px;">
    <h3 style="text-align: center;">Peak Foliage</h3>
    <table class="table-bordered table-hover" style="width: 100%;">
      <tbody>
        <tr>
          <th style="text-align: center;"><h4><b>Year<b></h4></th>
          <th style="text-align: center;"><h4><b>Date<b></h4></th>
        </tr>
        @foreach ($allPeaks as $peak)
          <tr>
            <th style="text-align: center;"><h4>{{ $peak->year }}</h4></th>
            <th style="text-align: center;"><h4>{{ $peak->date }}</h4></th>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
