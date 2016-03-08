@extends('layouts.raw')

@section('title', date('F', mktime(0, 0, 0, $summary->month, 10)) . ' - Monthly Summary')

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
      <div class="row better-row" style="max-width: 960px;">

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px; text-align: center; padding-top: 20px;"> <h3>{{ date('F', mktime(0, 0, 0, $summary->month, 10)) }}</h3> </div>
        <h3 class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="min-height: 25px; text-align: center; ">
          NOAA/ National Weather Service <br>
          Cooperative Climatological Station <br>
          West Hampstead, NH <br>
        </h3>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px; text-align: center; padding-top: 20px;"> <h3>{{ $summary->year }}</h3> </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Air Temperature (°F)</h4></div>

        <?php
          $MxA_str = strval($summary->max_avg);
          $MnA_str = strval($summary->min_avg);
          $A_str = strval($summary->avg);
          if(!strpos($MxA_str, ".")){
              $MxA_str .= ".0";
          }
          if(!strpos($MnA_str, ".")){
              $MnA_str .= ".0";
          }
          if(!strpos($A_str, ".")){
              $A_str .= ".0";
          }
        ?>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Average Maximum: {{ $MxA_str }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;">Highest: {{ $summary->highest }}</div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;">Dates: {{ $summary->highest_dates }}</div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Average Minimum: {{ $MnA_str }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;">Lowest: {{ $summary->lowest }}</div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;">Dates: {{ $summary->lowest_dates }}</div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Average: {{ $A_str }}</div>
        <div class="col-xs-6 col-sm-5 col-md-5 col-lg-5" style="min-height: 20px;">Total Heating Degree Days: {{ $summary->hdd_count }}</div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3" style="min-height: 20px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Mean Temp: {{ $AVG_TEMP }}</div>
        <div class="col-xs-6 col-sm-5 col-md-5 col-lg-5" style="min-height: 20px;">Total Cooling Degree Days: {{ $summary->cdd_count }}</div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3" style="min-height: 20px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Depart. from Normal: <?php
          $depart_temp_avg = $summary->avg - $AVG_TEMP;
          $depart_temp_avg = round($depart_temp_avg, 1);
          if($depart_temp_avg > 0){
              echo "+" . $summary->depart_temp_avg;
          } else {
              echo $summary->depart_temp_avg;
          }
        ?></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"><b>Maximums:</b> </div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 90 or greater: {{ $summary->max_over90 }} </div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"><b>Minimums:</b> </div>
        <div class="col-xs-3 col-sm-3 col-md-6 col-lg-6" style="min-height: 20px;"> 32 or lower: {{ $summary->min_below32 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-3 col-lg-3" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 32 or lower: {{ $summary->max_below32 }} </div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"></div>
        <div class="col-xs-3 col-sm-3 col-md-6 col-lg-6" style="min-height: 20px;"> 0 or lower: {{ $summary->min_below0 }} </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 10px; min-height: 5px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Precipitation (in.)</h4></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 2px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Total Precipitation: <?php
          if($summary->total_precip == 0 AND $summary->precip_grtrtrace > 0){
              echo "Trace";
          } else {
              echo number_format($summary->total_precip, 2);
          }
        ?> </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 2px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Mean Total: {{ $AVG_PRECIP }} </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Depart. from Normal: <?php
          $depart_precip_avg = $summary->total_precip - $AVG_PRECIP;
          if($depart_precip_avg > 0){
              echo "+" . $depart_precip_avg;
          } else {
              echo $depart_precip_avg;
          }
        ?> </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 2px"></div>
        <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;">Greatest Day: <?php
        if($summary->grts_precip == -77){
            echo "Trace";
        } else {
            echo number_format($summary->grts_precip, 2);
        }
        ?></div>
        <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9" style="min-height: 20px;">Dates: {{ $summary->grts_precip_dates }}</div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Total Annual Precip to date: {{ $precip_toDate }}</div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $summary->precip_grtrtrace }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.01" or greater: {{ $summary->grtr01 }} </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 0.10" or greater: {{ $summary->grtr10 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.50" or greater: {{ $summary->grtr50 }}  </div>
        <div class="col-xs-5 col-sm-5 col-md-6 col-lg-6" style="min-height: 20px;"> 1.00" or greater: {{ $summary->grtr100 }}  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 10px; min-height: 5px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Snowfall (in.)</h4></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Total Snowfall: <?php
          if($summary->total_sf == 0 AND $summary->sf_grtrtrace > 0){
            echo "Trace";
          } else {
            echo number_format($summary->total_sf, 1);
          }
         ?> </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Mean Total: {{ $AVG_SNFL }} </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Departure from Normal: <?php
          $depart_snfl_avg = $summary->total_sf - $AVG_SNFL;
          if($depart_snfl_avg > 0){
              echo "+" . $depart_snfl_avg;
          } else {
              echo $depart_snfl_avg;
          }
        ?> </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Greatest Snowfall: <?php
          if($summary->grts_sf == -77){
              echo "Trace";
          } else {
              echo number_format($summary->grts_sf, 1);
          }
        ?></div>
        <div class="col-xs-6 col-sm-7 col-md-8 col-lg-8" style="min-height: 20px;">Dates: {{ $summary->grts_sf_dates }}</div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Greatest Snow Depth: <?php
          if($summary->grts_sd == -77){
              echo "Trace";
          } else {
              echo number_format($summary->grts_sd, 0);
          }
        ?></div>
        <div class="col-xs-5 col-sm-6 col-md-7 col-lg-7" style="min-height: 20px;">Dates: {{ $summary->grts_sd_dates }}</div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="min-height: 20px;"> <b>Snowfall: </b></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $summary->sf_grtrtrace }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 1.0" or greater: {{ $summary->sf_grtr1 }} </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 3.0" or greater: {{ $summary->sf_grtr3 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 6.0" or greater: {{ $summary->sf_grtr6 }}  </div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 12.0" or greater: {{ $summary->sf_grtr12 }}  </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 18.0" or greater: {{ $summary->sf_grtr18 }}  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 10px"></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="min-height: 20px;"> <b>Snow Depth: </b></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $summary->sd_grtrtrace }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 1" or greater: {{ $summary->sd_grtr1 }} </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 3" or greater: {{ $summary->sd_grtr3 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 6" or greater: {{ $summary->sd_grtr6 }}  </div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 12" or greater: {{ $summary->sd_grtr12 }}  </div>
        <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4" style="min-height: 20px;"> 18" or greater: {{ $summary->sd_grtr18 }}  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 8px; min-height: 10px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Remarks</h4></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><?php echo $summary->remarks; ?></div>




      </div>
    @endif

  </div>
@endsection
