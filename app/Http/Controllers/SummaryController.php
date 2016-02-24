<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\Alert;
use Carbon\Carbon;

class SummaryController extends Controller{
    /*
    |--------------------------------------------------------------------------
    | Observations Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the display of all of the observation
    | pages
    |
    */

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showMonthlySubmit(){
        return view('summaries.monthly.submit');
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showAnnualSubmit(){
        return view('summaries.annual.submit');
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function calcMonthly(){

      if(\Input::get('password') == "cfs613"){
        $year  = \Input::get('year');
        $month = \Input::get('month');

        if (\Input::file('csvFile')->isValid())
        {
          $destinationPath = "./storage/csv/" . $year;
          $fileName = "West_Hampstead-" . $year . "_" . $month . ".csv";
          $fullpath = $destinationPath . "/" . $fileName;
          \Input::file('csvFile')->move($destinationPath, $fileName);

          $month = intval($month);
          $month_name = date("F", mktime(0, 0, 0, $month, 10));

          $monthly_CSV_handle = fopen($fullpath, "r");
          if(!$monthly_CSV_handle){
              die("Couldn't read file.");
          }
          //open 30 year normal file and if it cant be opened; die
          $yr_avg_handle = fopen("./storage/HMPN3-Monthly-Climate-Normals.csv", "r");
          if(!$yr_avg_handle){
              die("Couldn't read monthly climate normals file.");
          }

          // get 30 year average temp, precip, and snowfall
          $avg_temp_array = fgetcsv($yr_avg_handle);
          $avg_precip_array = fgetcsv($yr_avg_handle);
          $avg_snfl_array = fgetcsv($yr_avg_handle);
          $AVG_TEMP = $avg_temp_array[$month-1];
          $AVG_PRECIP = $avg_precip_array[$month-1];
          $AVG_SNFL = $avg_snfl_array[$month-1];

          // put observations into a 2D array; 1)row 2)column
          $obs_array = array();
          $i = 0;
          while(!feof($monthly_CSV_handle)){
              $obs_array[$i] = fgetcsv($monthly_CSV_handle);
              $i++;
          }

          $count = 0;
          $hi = 0;
          $li = 0;
          $max_total = 0;
          $min_total = 0;
          $highest = 0;
          $highest_dates = array();
          $lowest = 0;
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

          // loop through 2D $obs_array, making it into 1D $obs array
          // each loop is another row(day) in the csv file
          foreach($obs_array as $ob){
              // skip first line
              if($ob[0] == "DATE"){
                  continue;
              }
              if($count+1 > date('t', mktime(0, 0, 0, $month+1, 0, $year))){
                  break;
              }
              // find max and min for that day
              $max = intval($ob[1]);
              $min = intval($ob[2]);

              // find precip, snowfall and snowdepth for that day
              $precip = floatval($ob[4]);
              $SF = floatval($ob[5]);
              $SD = floatval($ob[6]);

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
              global $count;
              global $hi;
              global $li;
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
              // add that days max and min into the total of all the maxes and mins
              $max_total += $max;
              $min_total += $min;
              // test max and min for extremes
              if($max >= 90){
                  $max_over90++;
              }
              if($max <= 32){
                  $max_below32++;
              }
              if($min <= 32){
                  $min_below32++;
              }
              if($min <= 0){
                  $min_below0++;
              }
              // calculate heating or cooling degree days
              $today_avg = ($max + $min)/2;
              $points = round($today_avg - 65);
              if($points < 0){
                  $hdd_count += abs($points);
              } else {
                  $cdd_count += abs($points);
              }

              //add this days observations to the daily observation database table
              $day = $count + 1;
              if(\App\DailyObs::where('day', $day)->where('month', $month)->where('year', $year)->count() > 0){
                  $dailyObsObject = \App\DailyObs::where('day', $day)->where('month', $month)->where('year', $year)->first();
                  $dailyObsObject->max = $ob[1];
                  $dailyObsObject->min = $ob[2];
                  $dailyObsObject->atob = $ob[3];
                  if($ob[4] == "T"){
                      $dailyObsObject->precip = -77;
                  } else {
                      $dailyObsObject->precip = $ob[4];
                  }
                  if($ob[5] == "T"){
                      $dailyObsObject->snowfall = -77;
                  } else {
                      $dailyObsObject->snowfall = $ob[5];
                  }
                  if($ob[6] == "T"){
                      $dailyObsObject->snowdepth = -77;
                  } else {
                      $dailyObsObject->snowdepth = $ob[6];
                  }
                  if($dailyObsObject->save()){}
              } else {
                  $dailyObsObject = new \App\DailyObs;
                  $dailyObsObject->day = $day;
                  $dailyObsObject->month = $month;
                  $dailyObsObject->year = $year;
                  $dailyObsObject->max = $ob[1];
                  $dailyObsObject->min = $ob[2];
                  $dailyObsObject->atob = $ob[3];
                  if($ob[4] == "T"){
                      $dailyObsObject->precip = -77;
                  } else {
                      $dailyObsObject->precip = $ob[4];
                  }
                  if($ob[5] == "T"){
                      $dailyObsObject->snowfall = -77;
                  } else {
                      $dailyObsObject->snowfall = $ob[5];
                  }
                  if($ob[6] == "T"){
                      $dailyObsObject->snowdepth = -77;
                  } else {
                      $dailyObsObject->snowdepth = $ob[6];
                  }
                  if($dailyObsObject->save()){}
              }

              if($count == 0){
                  // set default values for highest and lowest temps
                  $highest = $max;
                  $lowest = $min;
                  $highest_dates[$hi] = $ob[0];
                  $lowest_dates[$li] = $ob[0];
                  $hi++;
                  $li++;
                  $count++;
                  continue;
              } else {
                  // compare that days max and min to highest and lowest temp so far
                  if($max > $highest){
                      $highest = $max;
                      $highest_dates = array();
                      $highest_dates[0] = $ob[0];
                      $hi = 1;
                  } elseif($max == $highest) {
                      $highest_dates[$hi] = $ob[0];
                      $hi++;
                  }
                  if($min < $lowest){
                      $lowest = $min;
                      $lowest_dates = array();
                      $lowest_dates[0] = $ob[0];
                      $li = 1;
                  } elseif($min == $lowest) {
                      $lowest_dates[$li] = $ob[0];
                      $li++;
                  }
              }

              // add that days precip to total precip and add that days snowfall to total snowfall
              $total_precip += $precip;
              $total_SF += $SF;
              // test precip, snowfall, and snowdepth if it is greater than certain amounts
              if($ob[4] == "T" OR $precip >= 0.01){
                  $precip_grtrTrace++;
              }
              if($precip >= 0.01){
                  $grtr01++;
              }
              if($precip >= 0.10){
                  $grtr10++;
              }
              if($precip >= 0.50){
                  $grtr50++;
              }
              if($precip >= 1.00){
                  $grtr100++;
              }
              if($ob[5] == "T" OR $SF >= 0.1){
                  $SF_grtrTrace++;
              }
              if($SF >= 0.5){
                  $SF_grtr50++;
              }
              if($SF >= 1.0){
                  $SF_grtr100++;
              }
              if($SF >= 5.0){
                  $SF_grtr500++;
              }
              if($SF >= 10.0){
                  $SF_grtr1000++;
              }
              if($ob[6] == "T" OR $SD >= 1){
                  $SD_grtrTrace++;
              }
              if($SD >= 0.5){
                  $SD_grtr50++;
              }
              if($SD >= 1.0){
                  $SD_grtr100++;
              }
              if($SD >= 5.0){
                  $SD_grtr500++;
              }
              if($SD >= 10.0){
                  $SD_grtr1000++;
              }
              if($count == 0){
                  // set default values for greatest precip, snowfall and snowdepth temps
                  $grts_precip = $precip;
                  $grts_SF = $SF;
                  $grts_SD = $SD;
                  $grts_precip_dates[$GPI] = $ob[0];
                  $grts_SF_dates[$GSFI] = $ob[0];
                  $grts_SD_dates[$GSDI] = $ob[0];
                  $GPI++;
                  $GSFI++;
                  $GSDI++;
                  $count++;
                  continue;
              } else {
                  // compare that days greatest precip, snowfall and snowdepth to
                  // greatest precip, snowfall and snowdepth temp so far
                  if($precip > $grts_precip){
                      $grts_precip = $precip;
                      $grts_precip_dates = array();
                      $grts_precip_dates[0] = $ob[0];
                      $GPI = 1;
                  } elseif($precip == $grts_precip) {
                      $grts_precip_dates[$GPI] = $ob[0];
                      $GPI++;
                  }

                  if($SF > $grts_SF){
                      $grts_SF = $SF;
                      $grts_SF_dates = array();
                      $grts_SF_dates[0] = $ob[0];
                      $GSFI = 1;
                  } elseif($SF == $grts_SF) {
                      $grts_SF_dates[$GSFI] = $ob[0];
                      $GSFI++;
                  }

                  if($SD > $grts_SD){
                      $grts_SD = $SD;
                      $grts_SD_dates = array();
                      $grts_SD_dates[0] = $ob[0];
                      $GSDI = 1;
                  } elseif($SD == $grts_SD) {
                      $grts_SD_dates[$GSDI] = $ob[0];
                      $GSDI++;
                  }
              }

              $count++;

              // stop loop at appropriate amount of days for month
              /*if($count >= 29 && ($month == 9 || $month == 4 || $month == 6 || $month == 11)){
                  break;
              } elseif($month == 2 && is_int(($year-2012)/4)){
                  if($count >= 28){
                      break;
                  }
              } elseif($month == 2 && !is_int(($year-2012)/4)){
                  if($count >= 27){
                      break;
                  }
              } elseif($count >= 30){
                  break;
              }*/

          }
          // calculate monthly max and min and average and format them appropriatly
          $max_avg = round($max_total / $count, 1);
          $min_avg = round($min_total / $count, 1);
          $avg = round(($max_avg + $min_avg) / 2, 1);
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
          $depart_temp_avg = round($depart_temp_avg, 1);
          if($depart_temp_avg > 0){
              $depart_temp_avg_str = "+" . $depart_temp_avg;
          } else {
              $depart_temp_avg_str = $depart_temp_avg;
          }

          // find how much monthly average departs from 30 year normals for precip and snowfall
          $depart_precip_avg = $total_precip - $AVG_PRECIP;
          if($depart_precip_avg > 0){
              $depart_precip_avg_str = "+" . $depart_precip_avg;
          } else {
              $depart_precip_avg_str = $depart_precip_avg;
          }

          $depart_snfl_avg = $total_SF - $AVG_SNFL;
          if($depart_snfl_avg > 0){
              $depart_snfl_avg_str = "+" . $depart_snfl_avg;
          } else {
              $depart_snfl_avg_str = $depart_snfl_avg;
          }

          //find if greatest values are traces
          if($grts_precip == 0 && $precip_grtrTrace > 0){
              $grts_precip = -77;
              $tempObArray = \App\DailyObs::where('month', $month)->where('year', $year)->get();
              $datesArray = array();
              $i = 0;
              foreach($tempObArray as $tempOb){
                  if($tempOb->precip == -77){
                      $datesArray[$i] = $tempOb->month . "/" . $tempOb->day . "/" . $tempOb->year;
                      $i++;
                  }
              }
              $grts_precip_dates = $datesArray;
          }
          if($grts_SF == 0 && $SF_grtrTrace > 0){
              $grts_SF = -77;
              $tempObArray = \App\DailyObs::where('month', $month)->where('year', $year)->get();
              $datesArray = array();
              $i = 0;
              foreach($tempObArray as $tempOb){
                  if($tempOb->snowfall == -77){
                      $datesArray[$i] = $tempOb->month . "/" . $tempOb->day . "/" . $tempOb->year;
                      $i++;
                  }
              }
              $grts_SF_dates = $datesArray;
          }
          if($grts_SD == 0 && $SD_grtrTrace > 0){
              $grts_SD = -77;
              $tempObArray = \App\DailyObs::where('month', $month)->where('year', $year)->get();
              $datesArray = array();
              $i = 0;
              foreach($tempObArray as $tempOb){
                  if($tempOb->snowdepth == -77){
                      $datesArray[$i] = $tempOb->month . "/" . $tempOb->day . "/" . $tempOb->year;
                      $i++;
                  }
              }
              $grts_SD_dates = $datesArray;
          }

          //calculate total precip to date
          $current_year_obs = \App\MonthlyObs::where('year', $year)->get();
          $year_precip = 0;
          if($current_year_obs) {
              for ($i = 0; $i <= $month - 2; $i++) {
                  $year_precip += $current_year_obs[$i]->total_precip;
              }
          }

          // handle traces
          if($total_precip == 0 AND $precip_grtrTrace > 0){
              $total_precip_str = "Trace";
          } else {
              $total_precip_str = number_format($total_precip, 2);
          }
          if($total_SF == 0 AND $SF_grtrTrace > 0){
              $total_SF_str = "Trace";
          } else {
              $total_SF_str = number_format($total_SF, 1);
          }
          if($grts_precip == -77){
              $grts_precip_str = "Trace";
          } else {
              $grts_precip_str = number_format($grts_precip, 2);
          }
          if($grts_SF == -77){
              $grts_SF_str = "Trace";
          } else {
              $grts_SF_str = number_format($grts_SF, 1);
          }
          if($grts_SD == -77){
              $grts_SD_str = "Trace";
          } else {
              $grts_SD_str = number_format($grts_SD, 0);
          }

          // format all date strings
          $highest_dates_str = "";
          $lowest_dates_str = "";
          $precip_dates_str = "";
          $SF_dates_str = "";
          $SD_dates_str = "";
          $i = 0;
          foreach($highest_dates as $date){
              global $i;
              $highest_dates_str .= $date;
              if(isset($highest_dates[$i+1])){
                  $highest_dates_str .= ",";
                  $i++;
              } else {
                  break;
              }
          }
          $i = 0;
          foreach($lowest_dates as $date){
              global $i;
              $lowest_dates_str .= $date;
              if(isset($lowest_dates[$i+1])){
                  $lowest_dates_str .= ",";
                  $i++;
              } else {
                  break;
              }
          }
          if($grts_precip != 0){
              $i = 0;
              foreach($grts_precip_dates as $date){
                  global $i;
                  $precip_dates_str .= $date;
                  if(isset($grts_precip_dates[$i+1])){
                      $precip_dates_str .= ",";
                      $i++;
                  } else {
                      break;
                  }
              }
          }
          if($grts_SF != 0){
              $i = 0;
              foreach($grts_SF_dates as $date){
                  global $i;
                  $SF_dates_str .= $date;
                  if(isset($grts_SF_dates[$i+1])){
                      $SF_dates_str .= ",";
                      $i++;
                  } else {
                      break;
                  }
              }
          }
          if($grts_SD != 0){
              $i = 0;
              foreach($grts_SD_dates as $date){
                  global $i;
                  $SD_dates_str .= $date;
                  if(isset($grts_SD_dates[$i+1])){
                      $SD_dates_str .= ",";
                      $i++;
                  } else {
                      break;
                  }
              }
          }

          //write all monthly values to annuals database table
          if(\App\MonthlyObs::where('month', $month)->where('year', $year)->count() > 0){
            $monthlyObsObject = \App\MonthlyObs::where('month', $month)->where('year', $year)->first();
            $monthlyObsObject->month = $month;
            $monthlyObsObject->year = intval($year);
            $monthlyObsObject->max_avg = $max_avg;
            $monthlyObsObject->min_avg = $min_avg;
            $monthlyObsObject->avg = $avg;
            $monthlyObsObject->depart_temp_avg = $depart_temp_avg;
            $monthlyObsObject->highest = $highest;
            $monthlyObsObject->highest_dates = $highest_dates_str;
            $monthlyObsObject->lowest = $lowest;
            $monthlyObsObject->lowest_dates = $lowest_dates_str;
            $monthlyObsObject->hdd_count = $hdd_count;
            $monthlyObsObject->cdd_count = ($cdd_count == null ? 0 : $cdd_count);
            $monthlyObsObject->max_over90 = ($max_over90 == null ? 0 : $max_over90);
            $monthlyObsObject->max_below32 = ($max_below32 == null ? 0 : $max_below32);
            $monthlyObsObject->min_below32 = ($min_below32 == null ? 0 : $min_below32);
            $monthlyObsObject->min_below0 = ($min_below0 == null ? 0 : $min_below0);
            $monthlyObsObject->total_precip = $total_precip;
            $monthlyObsObject->total_sf = $total_SF;
            $monthlyObsObject->grts_precip = $grts_precip;
            $monthlyObsObject->grts_precip_dates = $precip_dates_str;
            $monthlyObsObject->grts_sf = $grts_SF;
            $monthlyObsObject->grts_sf_dates = $SF_dates_str;
            $monthlyObsObject->grts_sd = $grts_SD;
            $monthlyObsObject->grts_sd_dates = $SD_dates_str;
            $monthlyObsObject->precip_grtrtrace = ($precip_grtrTrace == null ? 0 : $precip_grtrTrace);
            $monthlyObsObject->grtr01 = ($grtr01 == null ? 0 : $grtr01);
            $monthlyObsObject->grtr10 = ($grtr10 == null ? 0 : $grtr10);
            $monthlyObsObject->grtr50 = ($grtr50 == null ? 0 : $grtr50);
            $monthlyObsObject->grtr100 = ($grtr100 == null ? 0 : $grtr100);
            $monthlyObsObject->sf_grtrtrace = ($SF_grtrTrace == null ? 0 : $SF_grtrTrace);
            $monthlyObsObject->SF_grtr50 = ($SF_grtr50 == null ? 0 : $SF_grtr50);
            $monthlyObsObject->SF_grtr100 = ($SF_grtr100 == null ? 0 : $SF_grtr100);
            $monthlyObsObject->SF_grtr500 = ($SF_grtr500 == null ? 0 : $SF_grtr500);
            $monthlyObsObject->SF_grtr1000 = ($SF_grtr1000 == null ? 0 : $SF_grtr1000);
            $monthlyObsObject->sd_grtrtrace = ($SD_grtrTrace == null ? 0 : $SD_grtrTrace);
            $monthlyObsObject->SD_grtr50 = ($SD_grtr50 == null ? 0 : $SD_grtr50);
            $monthlyObsObject->SD_grtr100 = ($SD_grtr100 == null ? 0 : $SD_grtr100);
            $monthlyObsObject->SD_grtr500 = ($SD_grtr500 == null ? 0 : $SD_grtr500);
            $monthlyObsObject->SD_grtr1000 = ($SD_grtr1000 == null ? 0 : $SD_grtr1000);
            $monthlyObsObject->remarks = $monthlyObsObject->remarks;
            $monthlyObsObject->csv_file = $fullpath;
            if($monthlyObsObject->save()){
              event(new Alert('create', array('type' => 'success', 'body' => 'Summary Successfully Created.')));
              return redirect()->route('summaries.monthly.view', [ 'year' => $year, 'month' => $month ]);
            } else {
              event(new Alert('create', array('type' => 'danger', 'body' => 'Summary Not Successfully Created.')));
              return redirect()->route('summaries.monthly.submit');
            }
        } else {
            $monthlyObsObject = new \App\MonthlyObs;
            $monthlyObsObject->month = $month;
            $monthlyObsObject->year = intval($year);
            $monthlyObsObject->max_avg = $max_avg;
            $monthlyObsObject->min_avg = $min_avg;
            $monthlyObsObject->avg = $avg;
            $monthlyObsObject->depart_temp_avg = $depart_temp_avg;
            $monthlyObsObject->highest = $highest;
            $monthlyObsObject->highest_dates = $highest_dates_str;
            $monthlyObsObject->lowest = $lowest;
            $monthlyObsObject->lowest_dates = $lowest_dates_str;
            $monthlyObsObject->hdd_count = $hdd_count;
            $monthlyObsObject->cdd_count = ($cdd_count == null ? 0 : $cdd_count);
            $monthlyObsObject->max_over90 = ($max_over90 == null ? 0 : $max_over90);
            $monthlyObsObject->max_below32 = ($max_below32 == null ? 0 : $max_below32);
            $monthlyObsObject->min_below32 = ($min_below32 == null ? 0 : $min_below32);
            $monthlyObsObject->min_below0 = ($min_below0 == null ? 0 : $min_below0);
            $monthlyObsObject->total_precip = $total_precip;
            $monthlyObsObject->total_sf = $total_SF;
            $monthlyObsObject->grts_precip = $grts_precip;
            $monthlyObsObject->grts_precip_dates = $precip_dates_str;
            $monthlyObsObject->grts_sf = $grts_SF;
            $monthlyObsObject->grts_sf_dates = $SF_dates_str;
            $monthlyObsObject->grts_sd = $grts_SD;
            $monthlyObsObject->grts_sd_dates = $SD_dates_str;
            $monthlyObsObject->precip_grtrtrace = ($precip_grtrTrace == null ? 0 : $precip_grtrTrace);
            $monthlyObsObject->grtr01 = ($grtr01 == null ? 0 : $grtr01);
            $monthlyObsObject->grtr10 = ($grtr10 == null ? 0 : $grtr10);
            $monthlyObsObject->grtr50 = ($grtr50 == null ? 0 : $grtr50);
            $monthlyObsObject->grtr100 = ($grtr100 == null ? 0 : $grtr100);
            $monthlyObsObject->sf_grtrtrace = ($SF_grtrTrace == null ? 0 : $SF_grtrTrace);
            $monthlyObsObject->SF_grtr50 = ($SF_grtr50 == null ? 0 : $SF_grtr50);
            $monthlyObsObject->SF_grtr100 = ($SF_grtr100 == null ? 0 : $SF_grtr100);
            $monthlyObsObject->SF_grtr500 = ($SF_grtr500 == null ? 0 : $SF_grtr500);
            $monthlyObsObject->SF_grtr1000 = ($SF_grtr1000 == null ? 0 : $SF_grtr1000);
            $monthlyObsObject->sd_grtrtrace = ($SD_grtrTrace == null ? 0 : $SD_grtrTrace);
            $monthlyObsObject->SD_grtr50 = ($SD_grtr50 == null ? 0 : $SD_grtr50);
            $monthlyObsObject->SD_grtr100 = ($SD_grtr100 == null ? 0 : $SD_grtr100);
            $monthlyObsObject->SD_grtr500 = ($SD_grtr500 == null ? 0 : $SD_grtr500);
            $monthlyObsObject->SD_grtr1000 = ($SD_grtr1000 == null ? 0 : $SD_grtr1000);
            $monthlyObsObject->remarks = "";
            $monthlyObsObject->csv_file = $fullpath;
            if($monthlyObsObject->save()){
              event(new Alert('create', array('type' => 'success', 'body' => 'Summary Successfully Created.')));
              return redirect()->route('summaries.monthly.view', [ 'year' => $year, 'month' => $month ]);
            } else {
              event(new Alert('create', array('type' => 'danger', 'body' => 'Summary Not Successfully Created.')));
              return redirect()->route('summaries.monthly.submit');
            }
          }
        } else {
          event(new Alert('create', array('type' => 'danger', 'body' => 'Invalid File.')));
          return redirect()->route('summaries.monthly.submit');
        }
      } else {
        event(new Alert('create', array('type' => 'danger', 'body' => 'Incorrect Password.')));
        return redirect()->route('summaries.monthly.submit');
      }
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function calcAnnual(){

    }


    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function handleFile(){
      if (\Input::file('files')->isValid())
      {
        echo "swag";
      }
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showMonthlyHome(){
        return view('summaries.monthly.view');
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showMonthlySummary(Request $request, $year, $month){
      // get summary
      $summary = \App\MonthlyObs::where('month', $month)->where('year', $year)->first();

      // find precip to date
      $allSummaries = \App\MonthlyObs::where('year', $year);
      $precip_toDate = 0;
      foreach ($allSummaries as $result){
        $precip_toDate += $result->total_precip;
      }

      //open 30 year normal file and if it cant be opened; die
      $yr_avg_handle = fopen("./storage/HMPN3-Monthly-Climate-Normals.csv", "r");
      if(!$yr_avg_handle){
          die("Couldn't read monthly climate normals file.");
      }

      // get 30 year average temp, precip, and snowfall
      $avg_temp_array = fgetcsv($yr_avg_handle);
      $avg_precip_array = fgetcsv($yr_avg_handle);
      $avg_snfl_array = fgetcsv($yr_avg_handle);
      $AVG_TEMP = $avg_temp_array[$month-1];
      $AVG_PRECIP = $avg_precip_array[$month-1];
      $AVG_SNFL = $avg_snfl_array[$month-1];

      return view('summaries.monthly.view', ['summary' => $summary, 'AVG_TEMP' => $AVG_TEMP, 'AVG_PRECIP' => $AVG_PRECIP, 'AVG_SNFL' => $AVG_SNFL, 'precip_toDate' => $precip_toDate]);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showRawMonthlySummary(Request $request, $year, $month){
      // get summary
      $summary = \App\MonthlyObs::where('month', $month)->where('year', $year)->first();

      //open 30 year normal file and if it cant be opened; die
      $yr_avg_handle = fopen("./storage/HMPN3-Monthly-Climate-Normals.csv", "r");
      if(!$yr_avg_handle){
          die("Couldn't read monthly climate normals file.");
      }

      // find precip to date
      $allSummaries = \App\MonthlyObs::where('year', $year)->get();
      $precip_toDate = 0;
      foreach ($allSummaries as $result){
        $precip_toDate += $result->total_precip;
      }

      // get 30 year average temp, precip, and snowfall
      $avg_temp_array = fgetcsv($yr_avg_handle);
      $avg_precip_array = fgetcsv($yr_avg_handle);
      $avg_snfl_array = fgetcsv($yr_avg_handle);
      $AVG_TEMP = $avg_temp_array[$month-1];
      $AVG_PRECIP = $avg_precip_array[$month-1];
      $AVG_SNFL = $avg_snfl_array[$month-1];

      return view('summaries.monthly.raw', ['summary' => $summary, 'AVG_TEMP' => $AVG_TEMP, 'AVG_PRECIP' => $AVG_PRECIP, 'AVG_SNFL' => $AVG_SNFL, 'precip_toDate' => $precip_toDate]);
    }


    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showAnnualHome(){
        return view('summaries.annual.view');
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showAnnualSummary(Request $request, $year){
        $summary = \App\AnnualObs::where('year', $year)->first();

        return view('summaries.annual.view', ['summary' => $summary]);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showRawAnnualSummary(Request $request, $year){
        $summary = \App\AnnualObs::where('year', $year)->first();

        return view('summaries.annual.raw', ['summary' => $summary]);
    }
}
