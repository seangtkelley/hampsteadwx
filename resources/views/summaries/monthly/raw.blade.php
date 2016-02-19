@extends('layouts.raw')

@section('title', 'Monthly Summary')

@section('content')
  <style>
    body {
      padding-top: 0px !important;
    }
  </style>

  <script>

  </script>

  <div class="" style="min-height: 500px; width: 100%;">

    @if(isset($summary))
      <div class="row betterRow" style="max-width: 960px;">

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px; text-align: center; padding-top: 20px;"> <h3>{{ date('F', mktime(0, 0, 0, $summary->month, 10)) }}</h3> </div>
        <h3 class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="min-height: 25px; text-align: center; ">
          NOAA/ National Weather Service <br>
          Cooperative Climatological Station <br>
          West Hampstead, NH <br>
        </h3>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px; text-align: center; padding-top: 20px;"> <h3>{{ $summary->year }}</h3> </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Air Temperature (°F)</h4></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Average Maximum: {{ $summary->max_avg }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;">Highest: {{ $summary->highest }}</div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;">Dates: {{ $summary->highest_dates }}</div>

        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Average Minimum: {{ $summary->min_avg }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;">Lowest: {{ $summary->lowest }}</div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;">Dates: {{ $summary->lowest_dates }}</div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Average: {{ $summary->avg }}</div>
        <div class="col-xs-6 col-sm-5 col-md-5 col-lg-5" style="min-height: 20px;">Total Heating Degree Days: {{ $summary->hdd_count }}</div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3" style="min-height: 20px;"></div>

        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Mean Temp: {{ $AVG_TEMP }}</div>
        <div class="col-xs-6 col-sm-5 col-md-5 col-lg-5" style="min-height: 20px;">Total Cooling Degree Days: {{ $summary->cdd_count }}</div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3" style="min-height: 20px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Depart. from Normal: {{ $summary->depart_temp_avg }}</div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"><b>Maximums:</b> </div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 90 or greater: {{ $summary->max_over90 }} </div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"><b>Minimums:</b> </div>
        <div class="col-xs-3 col-sm-3 col-md-6 col-lg-6" style="min-height: 20px;"> 32 or lower: {{ $summary->min_below32 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 32 or lower: {{ $summary->max_below32 }} </div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"></div>
        <div class="col-xs-3 col-sm-3 col-md-6 col-lg-6" style="min-height: 20px;"> 0 or lower: {{ $summary->min_below0 }} </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 5px; min-height: 5px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Precipitation (in.)</h4></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Total Precipitation: {{ $summary->total_precip }} </div>

        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Mean Total: {{ $AVG_PRECIP }} </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Depart. from Normal: N/A </div>

        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Total Precip to date: N/A</div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;">Greatest Day: {{ $summary->grts_precip }}</div>
        <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9" style="min-height: 20px;">Dates: {{ $summary->grts_precip_dates }}</div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $summary->precip_grtrtrace }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.01" or greater: {{ $summary->grtr01 }} </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 0.10" or greater: {{ $summary->grtr10 }} </div>

        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.50" or greater: {{ $summary->grtr50 }}  </div>
        <div class="col-xs-5 col-sm-5 col-md-6 col-lg-6" style="min-height: 20px;"> 1.00" or greater: {{ $summary->grtr100 }}  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Total Snowfall: {{ $summary->total_sf }} </div>

        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Mean Total: {{ $AVG_SNFL }} </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Departure from Normal: N/A </div>

        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Greatest Snowfall: {{ $summary->grts_sf }}</div>
        <div class="col-xs-6 col-sm-7 col-md-8 col-lg-8" style="min-height: 20px;">Dates: {{ $summary->grts_sf_dates }}</div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Greatest Snow Depth: {{ $summary->grts_sd }}</div>
        <div class="col-xs-5 col-sm-6 col-md-7 col-lg-7" style="min-height: 20px;">Dates: {{ $summary->grts_sd_dates }}</div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="min-height: 20px;"> <b>Snowfall: </b></div>

        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $summary->sf_grtrtrace }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.50" or greater: N/A </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 1.00" or greater: N/A </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 5.00" or greater: N/A  </div>
        <div class="col-xs-7 col-sm-7 col-md-8 col-lg-8" style="min-height: 20px;"> 10.00" or greater: N/A  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 25px"></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="min-height: 20px;"> <b>Snow Depth: </b></div>

        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $summary->sd_grtrtrace }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.50" or greater: N/A </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 1.00" or greater: N/A </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 5.00" or greater: N/A  </div>
        <div class="col-xs-5 col-sm-5 col-md-6 col-lg-6" style="min-height: 20px;"> 10.00" or greater: N/A  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 5px; min-height: 10px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Remarks</h4></div>




      </div>
    @endif

  </div>
@endsection
