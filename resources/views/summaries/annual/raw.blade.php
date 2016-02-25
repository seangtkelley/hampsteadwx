@extends('layouts.raw')

@section('title', $year . ' Annual Summary')

@section('content')
  <style>
    body {
      padding-top: 0px !important;
    }
  </style>

  <script>

  </script>
  </script>

  <?php
    $count;
    $hi = 0;
    $li = 0;
    $max_total;
    $min_total;
    $avg_total;
    $highest;
    $highest_dates = array();
    $lowest;
    $lowest_dates = array();
    $hdd_count = 0;
    $cdd_count = 0;
    $max_over90 = 0;
    $max_below32 = 0;
    $min_below0 = 0;
    $min_below32 = 0;
    $total_precip;
    $total_SF;
    $grts_precip;
    $grts_precip_dates;
    $GPI = 0;
    $grts_SF;
    $grts_SF_dates;
    $GSFI = 0;
    $grts_SD;
    $grts_SD_dates;
    $GSDI = 0;
    $grtr01 = 0;
    $grtr10 = 0;
    $grtr50 = 0;
    $grtr100 = 0;
    $precip_grtrTrace = 0;
    $SF_grtrTrace = 0;
    $SF_grtr50 = 0;
    $SF_grtr100 = 0;
    $SF_grtr500 = 0;
    $SF_grtr1000 = 0;
    $SD_grtrTrace = 0;
    $SD_grtr50 = 0;
    $SD_grtr100 = 0;
    $SD_grtr500 = 0;
    $SD_grtr1000 = 0;
    // loop through object observation array
    // each loop is another row(month) in the database
    foreach($obs_array as $ob){
        // find max and min for that month
        $max = $ob->max_avg;
        $min = $ob->min_avg;

        // find precip, snowfall and snowdepth for that day
        $precip = $ob->total_precip;
        $SF = $ob->total_SF;

        // pull in global variables for use in foreach loop
        global $highest;
        global $highest_dates;
        global $lowest;
        global $lowest_dates;
        global $hdd_count;
        global $cdd_count;
        global $max_over90;
        global $max_below32;
        global $min_below32;
        global $min_below0;
        global $max_total;
        global $min_total;
        global $avg_total;
        global $count;
        global $hi;
        global $li;
        global $month_num;
        global $total_precip;
        global $total_SF;
        global $grts_precip;
        global $grts_precip_dates;
        global $GPI;
        global $grts_SF;
        global $grts_SF_dates;
        global $GSFI;
        global $grts_SD;
        global $grts_SD_dates;
        global $GSDI;
        global $grtr01;
        global $grtr10;
        global $grtr50;
        global $grtr100;
        global $precip_grtrTrace;
        global $SF_grtrTrace;
        global $SF_grtr50;
        global $SF_grtr100;
        global $SF_grtr500;
        global $SF_grtr1000;
        global $SD_grtrTrace;
        global $SD_grtr50;
        global $SD_grtr100;
        global $SD_grtr500;
        global $SD_grtr1000;

        // add that months max and min into the total of all the maxes and mins
        $max_total += $max;
        $min_total += $min;
        $avg_total += $ob->avg;

        // add the months extremes to current totals
        $max_over90 += $ob->max_over90;
        $max_below32 += $ob->max_below32;
        $min_below32 += $ob->min_below32;
        $min_below0 += $ob->min_below0;

        // calculate heating or cooling degree days
        $hdd_count += $ob->hdd_count;
        $cdd_count += $ob->cdd_count;

        if($count == 0){
            // set default values for highest and lowest temps
            $highest = $ob->highest;
            $lowest = $ob->lowest;
            $highest_dates[$hi] = $ob->highest_dates;
            $lowest_dates[$li] = $ob->lowest_dates;
            $hi++;
            $li++;
            $count++;
            continue;
        } else {
            // compare that months highest and lowest to highest and lowest temp so far
            if( $ob->highest > $highest){
                $highest = $ob->highest;
                $highest_dates = array();
                $highest_dates[0] = $ob->highest_dates;
                $hi = 1;
            } elseif($ob->highest == $highest) {
                $highest_dates[$hi] = $ob->highest_dates;
                $hi++;
            }
            if($ob->lowest < $lowest){
                $lowest = $ob->lowest;
                $lowest_dates = array();
                $lowest_dates[0] = $ob->lowest_dates;
                $li = 1;
            } elseif($ob->lowest == $lowest) {
                $lowest_dates[$li] = $ob->lowest_dates;
                $li++;
            }
        }

        // add that months precip to total precip and add that months snowfall to total snowfall
        $total_precip += $precip;
        $total_SF += $SF;

        // add the months extremes to current totals
        $grtr01 += $ob->grtr01;
        $grtr10 += $ob->grtr10;
        $grtr50 += $ob->grtr50;
        $grtr100 += $ob->grtr100;
        $precip_grtrTrace += $ob->precip_grtrTrace;
        $SF_grtrTrace += $ob->sf_grtrtrace;
        $SF_grtr50 += $ob->SF_grtr50;
        $SF_grtr100 += $ob->SF_grtr100;
        $SF_grtr500 += $ob->SF_grtr500;
        $SF_grtr1000 += $ob->SF_grtr1000;
        $SD_grtrTrace += $ob->sd_grtrtrace;
        $SD_grtr50 += $ob->SD_grtr50;
        $SD_grtr100 += $ob->SD_grtr100;
        $SD_grtr500 += $ob->SD_grtr500;
        $SD_grtr1000 += $ob->SD_grtr1000;

        if($count == 0){
            // set default values for greatest precip, snowfall and snowdepth temps
            $grts_precip = $ob->grts_precip;
            $grts_SF = $ob->grts_SF;
            $grts_SD = $ob->grts_SD;
            $grts_precip_dates[$GPI] = $ob->grts_precip_dates;
            $grts_SF_dates[$GSFI] = $ob->grts_SF_dates;
            $grts_SD_dates[$GSDI] = $ob->grts_SD_dates;
            $GPI++;
            $GSFI++;
            $GSDI++;
            $count++;
            continue;
        } else {
            // compare that months greatest precip, snowfall and snowdepth to
            // greatest precip, snowfall and snowdepth temp so far
            if($ob->grts_precip > $grts_precip){
                $grts_precip = $ob->grts_precip;
                $grts_precip_dates = array();
                $grts_precip_dates[0] = $ob->grts_precip_dates;
                $GPI = 1;
            } elseif($ob->grts_precip == $grts_precip) {
                $grts_precip_dates[$GPI] = $ob->grts_precip_dates;
                $GPI++;
            }

            if($ob->grts_SF > $grts_SF){
                $grts_SF = $ob->grts_SF;
                $grts_SF_dates = array();
                $grts_SF_dates[0] = $ob->grts_SF_dates;
                $GSFI = 1;
            } elseif($ob->grts_SF == $grts_SF) {
                $grts_SF_dates[$GSFI] = $ob->grts_SF_dates;
                $GSFI++;
            }

            if($ob->grts_SD > $grts_SD){
                $grts_SD = $ob->grts_SD;
                $grts_SD_dates = array();
                $grts_SD_dates[0] = $ob->grts_SD_dates;
                $GSDI = 1;
            } elseif($ob->grts_SD == $grts_SD) {
                $grts_SD_dates[$GSDI] = $ob->grts_SD_dates;
                $GSDI++;
            }
        }
        $count++;
    }
    // calculate monthly max and min and average and format them appropriatly
    $max_avg = round($max_total / $count, 1);
    $min_avg = round($min_total / $count, 1);
    $avg = round($avg_total / $count, 1);
    $MxA_str = strval($max_avg);
    $MnA_str = strval($min_avg);
    $A_str = strval($avg);
    if(!strpos($MxA_str, ".")){
        $MxA_str .= ".0";
    }
    if(!strpos($MnA_str, ".")){
        $MnA_str .= ".0";
    }
    if(!strpos($A_str, ".")){
        $A_str .= ".0";
    }

    // find how much monthly average departs from 30 year normals
    $depart_temp_avg = $avg - $AVG_TEMP;
    if($depart_temp_avg > 0){
        $depart_temp_avg_str = "+" . number_format($depart_temp_avg, 1);
    } else {
        $depart_temp_avg_str = number_format($depart_temp_avg, 1);
    }

    // find how much monthly average departs from 30 year normals for precip and snowfall
    $depart_precip_avg = $total_precip - $AVG_PRECIP;
    if($depart_precip_avg > 0){
        $depart_precip_avg_str = "+" . number_format($depart_precip_avg, 2);
    } else {
        $depart_precip_avg_str = number_format($depart_precip_avg, 2);
    }

    $depart_snfl_avg = $total_SF - $AVG_SNFL;
    if($depart_snfl_avg > 0){
        $depart_snfl_avg_str = "+" . number_format($depart_snfl_avg, 1);
    } else {
        $depart_snfl_avg_str = number_format($depart_snfl_avg, 1);
    }
  ?>

  <div class="" style="min-height: 500px; width: 100%;">

    @if(isset($year))
      <div class="row betterRow" style="max-width: 960px;">

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px; text-align: center; padding-top: 20px;"> <h3>{{ $year }}</h3> </div>
        <h3 class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="min-height: 25px; text-align: center; ">
          NOAA/ National Weather Service <br>
          Cooperative Climatological Station <br>
          West Hampstead, NH <br>
        </h3>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px; text-align: center; padding-top: 20px;"> <h3>John G. W. Kelley</h3> </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Air Temperature (°F)</h4></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
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

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Average: {{ $A_str }}</div>
        <div class="col-xs-6 col-sm-5 col-md-5 col-lg-5" style="min-height: 20px;">Total Heating Degree Days: {{ $hdd_count }}</div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3" style="min-height: 20px;"></div>

        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Mean Temp: {{ $AVG_TEMP }}</div>
        <div class="col-xs-6 col-sm-5 col-md-5 col-lg-5" style="min-height: 20px;">Total Cooling Degree Days: {{ $cdd_count }}</div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3" style="min-height: 20px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Depart. from Normal: {{ $depart_temp_avg_str }}</div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"><b>Maximums:</b> </div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 90 or greater: {{ $max_over90 }} </div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"><b>Minimums:</b> </div>
        <div class="col-xs-3 col-sm-3 col-md-6 col-lg-6" style="min-height: 20px;"> 32 or lower: {{ $min_below32 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 32 or lower: {{ $max_below32 }} </div>
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="min-height: 20px;"></div>
        <div class="col-xs-3 col-sm-3 col-md-6 col-lg-6" style="min-height: 20px;"> 0 or lower: {{ $min_below0 }} </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 5px; min-height: 5px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Precipitation (in.)</h4></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Total Precipitation: {{ $total_precip }} </div>

        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Mean Total: {{ $AVG_PRECIP }} </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Depart. from Normal: {{ $depart_precip_avg_str }}  </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
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

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $precip_grtrTrace }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.01" or greater: {{ $grtr01 }} </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 0.10" or greater: {{ $grtr10 }} </div>

        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.50" or greater: {{ $grtr50 }}  </div>
        <div class="col-xs-5 col-sm-5 col-md-6 col-lg-6" style="min-height: 20px;"> 1.00" or greater: {{ $grtr100 }}  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px;"></div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Total Snowfall: {{ $total_SF }} </div>

        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Mean Total: {{ $AVG_SNFL }} </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;">Departure from Normal: {{ $depart_snfl_avg_str }} </div>

        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Greatest Snowfall: {{ $grts_SF }}</div>
        <div class="col-xs-6 col-sm-7 col-md-8 col-lg-8" style="min-height: 20px;">Dates: <?php
            $i = 0;
            if($grts_SF != 0){
                foreach($grts_SF_dates as $date){
                    global $i;
                    echo $date;
                    if(isset($grts_SF_dates[$i+1])){
                        echo ", ";
                        $i++;
                    } else {
                        break;
                    }
                }
            }
        ?>
        </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-height: 20px;">Greatest Snow Depth: {{ $grts_SD }}</div>
        <div class="col-xs-5 col-sm-6 col-md-7 col-lg-7" style="min-height: 20px;">Dates: <?php
            $i = 0;
            if($grts_SF != 0){
                foreach($grts_SD_dates as $date){
                    global $i;
                    echo $date;
                    if(isset($grts_SD_dates[$i+1])){
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

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="min-height: 25px"></div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" style="min-height: 20px;"><h5>Number of Days with: </h5></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="min-height: 20px;"> <b>Snowfall: </b></div>

        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $SF_grtrTrace }}</div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.50" or greater: {{ $SF_grtr50 }} </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 1.00" or greater: {{ $SF_grtr100 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 5.00" or greater: {{ $SF_grtr500 }}  </div>
        <div class="col-xs-7 col-sm-7 col-md-8 col-lg-8" style="min-height: 20px;"> 10.00" or greater: {{ $SF_grtr1000 }}  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 25px"></div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="min-height: 20px;"> <b>Snow Depth: </b></div>

        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> A trace or more: {{ $SD_grtrTrace }} </div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 0.50" or greater: {{ $SD_grtr50 }} </div>
        <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="min-height: 20px;"> 1.00" or greater: {{ $SD_grtr100 }} </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="min-height: 25px"></div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2" style="min-height: 20px;"> 5.00" or greater: {{ $SD_grtr500 }}  </div>
        <div class="col-xs-5 col-sm-5 col-md-6 col-lg-6" style="min-height: 20px;"> 10.00" or greater: {{ $SD_grtr1000 }}  </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 5px; min-height: 10px; border-top: 1px solid grey;"></div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 20px; margin-top: 5px;"><h4>Remarks</h4></div>




      </div>
    @endif

  </div>
@endsection
