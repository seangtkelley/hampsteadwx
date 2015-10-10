@extends('layouts.raw')

@section('title', 'Monthly Summary')

@section('content')
  <style>
    body {
      padding-top: 0px !important;
    }
  </style>

  <div class="container" style="min-height: 500px;">

    @if(isset($summary))
      <div class="row betterRow">
        <div class="col-lg-2" style="min-height: 50px"></div>
        <div class="col-lg-8">
          <h2 style="text-align: center;">
            NOAA/ National Weather Service <br>
            Cooperative Climatological Station <br>
            West Hampstead, NH <br>
          </h2>
        </div>
        <div class="col-lg-2" style="min-height: 130px"></div>

        <div class="col-lg-2" style="min-height: 25px; text-align: center;"> <h3>{{ date('F', mktime(0, 0, 0, $summary->month, 10)) }}</h3> </div>
        <div class="col-lg-8" style="min-height: 25px"></div>
        <div class="col-lg-2" style="min-height: 25px; text-align: center;"> <h3>{{ $summary->year }}</h3> </div>

        <div class="col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>

        <div class="col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Air Temperature (°F)</h4></div>

        <div class="col-lg-1" style="min-height: 25px"></div>
        <div class="col-lg-3" style="min-height: 20px;">Average Maximum: {{ $summary->max_avg }}</div>
        <div class="col-lg-2" style="min-height: 20px;">Highest: {{ $summary->highest }}</div>
        <div class="col-lg-6" style="min-height: 20px;">Dates: {{ $summary->highest_dates }}</div>

        <!--<div class="col-lg-1" style="min-height: 25px"></div>-->
        <div class="col-lg-3" style="min-height: 20px;">Average Minimum: {{ $summary->min_avg }}</div>
        <div class="col-lg-2" style="min-height: 20px;">Lowest: {{ $summary->lowest }}</div>
        <div class="col-lg-6" style="min-height: 20px;">Dates: {{ $summary->lowest_dates }}</div>

        <div class="col-lg-1" style="min-height: 25px"></div>
        <div class="col-lg-3" style="min-height: 20px;">Average: {{ $summary->avg }}</div>
        <div class="col-lg-5" style="min-height: 20px;">Total Heating Degree Days: {{ $summary->hdd_count }}</div>
        <div class="col-lg-3" style="min-height: 20px;"></div>

        <div class="col-lg-3" style="min-height: 20px;">Mean Temp: N/A</div>
        <div class="col-lg-5" style="min-height: 20px;">Total Cooling Degree Days: {{ $summary->cdd_count }}</div>
        <div class="col-lg-3" style="min-height: 20px;"></div>

        <div class="col-lg-1" style="min-height: 25px"></div>
        <div class="col-lg-11" style="min-height: 20px;">Departure from Normal: {{ $summary->depart_temp_avg }}</div>

        <div class="col-lg-12" style="min-height: 5px;"></div>

        <div class="col-lg-1" style="min-height: 25px"></div>
        <div class="col-lg-11" style="min-height: 20px;"></div>


      </div>
    @endif

  </div>
@endsection
