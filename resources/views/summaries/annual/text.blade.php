@extends('layouts.raw')

@section('title', $year . ' Annual Summary')

@section('content')
  <style>
    body {
      padding-top: 0px !important;
    }
  </style>

  <div class="" style="min-height: 500px; width: 100%;">

    @if(isset($year))
      <div class="row better-row" style="max-width: 960px;">

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px; text-align: center; padding-top: 20px;"> <h3>{{ $year }}</h3> </div>
        <h3 class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="min-height: 20px; text-align: center; ">
          NOAA/ National Weather Service <br>
          Cooperative Climatological Station <br>
          West Hampstead, NH <br>
        </h3>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px; text-align: center; padding-top: 20px;"> <h3>John Kelley</h3> </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Air Temperature (°F)</h4></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Average Maximum: {{ $MxA_str }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;">Highest: {{ $highest }}</div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;">Dates: <?php
            $i = 0;
            foreach($highest_dates as $date){
                global $i;
                echo $date;
                if(isset($highest_dates[$i+1])){
                    echo ", ";
                    $i++;
                } else {
                    break;
                }
            }
        ?>
      </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Average Minimum: {{ $MnA_str }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;">Lowest: {{ $lowest }}</div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;">Dates: <?php
            $i = 0;
            foreach($lowest_dates as $date){
                global $i;
                echo $date;
                if(isset($lowest_dates[$i+1])){
                    echo ", ";
                    $i++;
                } else {
                    break;
                }
            }
        ?>
        </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Average: {{ $A_str }}</div>
        <div class="col-xs-6 col-sm-5 col-md-5 col-lg-5" style="min-height: 20px;">Total Heating Degree Days: {{ $hdd_count }}</div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3" style="min-height: 20px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Mean Temp: {{ $AVG_TEMP }}</div>
        <div class="col-xs-6 col-sm-5 col-md-5 col-lg-5" style="min-height: 20px;">Total Cooling Degree Days: {{ $cdd_count }}</div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3" style="min-height: 20px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Depart. from Normal: {{ $depart_temp_avg_str }}</div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"><b>Maximums:</b> </div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 90 or greater: {{ $max_over90 }} </div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"><b>Minimums:</b> </div>
        <div class="col-xs-3 col-sm-3 col-md-6 col-lg-6" style="min-height: 20px;"> 32 or lower: {{ $min_below32 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-3 col-lg-3" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 32 or lower: {{ $max_below32 }} </div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"></div>
        <div class="col-xs-3 col-sm-3 col-md-6 col-lg-6" style="min-height: 20px;"> 0 or lower: {{ $min_below0 }} </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 10px; min-height: 5px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Precipitation (in.)</h4></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Total Precipitation: {{ $total_precip }} </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Mean Total: {{ $AVG_PRECIP }} </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Depart. from Normal: {{ $depart_precip_avg_str }}  </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;">Greatest Day: {{ $grts_precip }}</div>
        <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9" style="min-height: 20px;">Dates: <?php
            $i = 0;
            foreach($grts_precip_dates as $date){
                global $i;
                echo $date;
                if(isset($grts_precip_dates[$i+1])){
                    echo ", ";
                    $i++;
                } else {
                    break;
                }
            }
        ?>
      </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $precip_grtrtrace }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.01" or greater: {{ $grtr01 }} </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 0.10" or greater: {{ $grtr10 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.50" or greater: {{ $grtr50 }}  </div>
        <div class="col-xs-5 col-sm-5 col-md-6 col-lg-6" style="min-height: 20px;"> 1.00" or greater: {{ $grtr100 }}  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 10px; min-height: 5px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Snowfall (in.)</h4></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Total Snowfall: {{ $total_sf }} </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Mean Total: {{ $AVG_SNFL }} </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Departure from Normal: {{ $depart_snfl_avg_str }} </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Greatest Snowfall: {{ $grts_sf }}</div>
        <div class="col-xs-6 col-sm-7 col-md-8 col-lg-8" style="min-height: 20px;">Dates: <?php
            $i = 0;
            if($grts_sf != 0){
                foreach($grts_sf_dates as $date){
                    global $i;
                    echo $date;
                    if(isset($grts_sf_dates[$i+1])){
                        echo ", ";
                        $i++;
                    } else {
                        break;
                    }
                }
            }
        ?>
        </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Greatest Snow Depth: {{ $grts_sd }}</div>
        <div class="col-xs-5 col-sm-6 col-md-7 col-lg-7" style="min-height: 20px;">Dates: <?php
            $i = 0;
            if($grts_sf != 0){
                foreach($grts_sd_dates as $date){
                    global $i;
                    echo $date;
                    if(isset($grts_sd_dates[$i+1])){
                        echo ", ";
                        $i++;
                    } else {
                        break;
                    }
                }
            }
        ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 20px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="min-height: 20px;"> <b>Snowfall: </b></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $sf_grtrtrace }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 1.0" or greater: {{ $sf_grtr1 }} </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 3.0" or greater: {{ $sf_grtr3 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 6.0" or greater: {{ $sf_grtr6 }}  </div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 12.0" or greater: {{ $sf_grtr12 }}  </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 18.0" or greater: {{ $sf_grtr18 }}  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 10px"></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="min-height: 20px;"> <b>Snow Depth: </b></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $sd_grtrtrace }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 1" or greater: {{ $sd_grtr1 }} </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 3" or greater: {{ $sd_grtr3 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 20px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 6" or greater: {{ $sd_grtr6 }}  </div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 12" or greater: {{ $sd_grtr12 }}  </div>
        <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4" style="min-height: 20px;"> 18" or greater: {{ $sd_grtr18 }}  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 8px; min-height: 10px; border-top: 1px solid grey;"></div>
      </div>
    @endif

  </div>
@endsection
