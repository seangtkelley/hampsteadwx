<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\Alert;
use Carbon\Carbon;

class SummaryController extends Controller
{
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
    public function showMonthlySubmit()
    {
        return view('summaries.monthly.submit');
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function calcMonthly()
    {

        if (\Input::get('password') == "cfs613") {
            $year = \Input::get('year');
            $month = \Input::get('month');

            if (\Input::file('csvFile')->isValid()) {
                $destinationPath = "./storage/csv/" . $year;
                $fileName = "West_Hampstead-" . $year . "_" . $month . ".csv";
                $fullpath = $destinationPath . "/" . $fileName;
                \Input::file('csvFile')->move($destinationPath, $fileName);

                $month = intval($month);
                $month_name = date("F", mktime(0, 0, 0, $month, 10));

                $monthly_CSV_handle = fopen($fullpath, "r");
                if (!$monthly_CSV_handle) {
                    die("Couldn't read file.");
                }
                //open 30 year normal file and if it cant be opened; die
                $yr_avg_handle = fopen("./storage/HMPN3-Monthly-Climate-Normals.csv", "r");
                if (!$yr_avg_handle) {
                    die("Couldn't read monthly climate normals file.");
                }

                // get 30 year average temp, precip, and snowfall
                $avg_temp_array = fgetcsv($yr_avg_handle);
                $avg_precip_array = fgetcsv($yr_avg_handle);
                $avg_snfl_array = fgetcsv($yr_avg_handle);
                $AVG_TEMP = $avg_temp_array[$month - 1];
                $AVG_PRECIP = $avg_precip_array[$month - 1];
                $AVG_SNFL = $avg_snfl_array[$month - 1];

                // put observations into a 2D array; 1)row 2)column
                $obs_array = array();
                $i = 0;
                while (!feof($monthly_CSV_handle)) {
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
                $total_precip = 0;
                $total_sf = 0;
                $grts_precip = 0;
                $grts_precip_dates = "";
                $GPI = 0;
                $grts_SF = 0;
                $grts_SF_dates = "";
                $GSFI = 0;
                $grts_SD = 0;
                $grts_SD_dates = "";
                $GSDI = 0;
                $grtr01 = 0;
                $grtr10 = 0;
                $grtr50 = 0;
                $grtr100 = 0;
                $precip_grtrtrace = 0;
                $sf_grtrtrace = 0;
                $sf_grtr1 = 0;
                $sf_grtr3 = 0;
                $sf_grtr6 = 0;
                $sf_grtr12 = 0;
                $sf_grtr18 = 0;
                $sd_grtrtrace = 0;
                $sd_grtr1 = 0;
                $sd_grtr3 = 0;
                $sd_grtr6 = 0;
                $sd_grtr12 = 0;
                $sd_grtr18 = 0;

                // loop through 2D $obs_array, making it into 1D $obs array
                // each loop is another row(day) in the csv file
                foreach ($obs_array as $ob) {
                    // skip first line
                    if ($ob[0] == "DATE") {
                        continue;
                    }
                    if ($count + 1 > date('t', mktime(0, 0, 0, $month + 1, 0, $year))) {
                        break;
                    }

                    event(new Alert('create', array('type' => 'info', 'body' => $ob[0])));

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
                    global $total_sf;
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
                    global $precip_grtrtrace;
                    global $sf_grtrtrace;
                    global $sf_grtr1;
                    global $sf_grtr3;
                    global $sf_grtr6;
                    global $sf_grtr12;
                    global $sf_grtr18;
                    global $sd_grtrtrace;
                    global $sd_grtr1;
                    global $sd_grtr3;
                    global $sd_grtr6;
                    global $sd_grtr12;
                    global $sd_grtr18;
                    // add that days max and min into the total of all the maxes and mins
                    $max_total += $max;
                    $min_total += $min;
                    // test max and min for extremes
                    if ($max >= 90) {
                        $max_over90++;
                    }
                    if ($max <= 32) {
                        $max_below32++;
                    }
                    if ($min <= 32) {
                        $min_below32++;
                    }
                    if ($min <= 0) {
                        $min_below0++;
                    }
                    // calculate heating or cooling degree days
                    $today_avg = ($max + $min) / 2;
                    $points = round($today_avg - 65);
                    if ($points < 0) {
                        $hdd_count += abs($points);
                    } else {
                        $cdd_count += abs($points);
                    }

                    //add this days observations to the daily observation database table
                    $day = $count + 1;
                    if (\App\DailyObs::where('day', $day)->where('month', $month)->where('year', $year)->count() > 0) {
                        $dailyObsObject = \App\DailyObs::where('day', $day)->where('month', $month)->where('year', $year)->first();
                        $dailyObsObject->max = $ob[1];
                        $dailyObsObject->min = $ob[2];
                        $dailyObsObject->atob = $ob[3];
                        if ($ob[4] == "T") {
                            $dailyObsObject->precip = -77;
                        } else {
                            $dailyObsObject->precip = $ob[4];
                        }
                        if ($ob[5] == "T") {
                            $dailyObsObject->snowfall = -77;
                        } else {
                            $dailyObsObject->snowfall = $ob[5];
                        }
                        if ($ob[6] == "T") {
                            $dailyObsObject->snowdepth = -77;
                        } else {
                            $dailyObsObject->snowdepth = $ob[6];
                        }
                        if ($dailyObsObject->save()) {
                        }
                    } else {
                        $dailyObsObject = new \App\DailyObs;
                        $dailyObsObject->day = $day;
                        $dailyObsObject->month = $month;
                        $dailyObsObject->year = $year;
                        $dailyObsObject->max = $ob[1];
                        $dailyObsObject->min = $ob[2];
                        $dailyObsObject->atob = $ob[3];
                        if ($ob[4] == "T") {
                            $dailyObsObject->precip = -77;
                        } else {
                            $dailyObsObject->precip = $ob[4];
                        }
                        if ($ob[5] == "T") {
                            $dailyObsObject->snowfall = -77;
                        } else {
                            $dailyObsObject->snowfall = $ob[5];
                        }
                        if ($ob[6] == "T") {
                            $dailyObsObject->snowdepth = -77;
                        } else {
                            $dailyObsObject->snowdepth = $ob[6];
                        }
                        if ($dailyObsObject->save()) {
                        }
                    }

                    if ($count == 0) {
                        // set default values for highest and lowest temps
                        $highest = $max;
                        $lowest = $min;
                        $highest_dates[$hi] = $ob[0];
                        $lowest_dates[$li] = $ob[0];
                        $hi++;
                        $li++;
                    } else {
                        // compare that days max and min to highest and lowest temp so far
                        if ($max > $highest) {
                            $highest = $max;
                            $highest_dates = array();
                            $highest_dates[0] = $ob[0];
                            $hi = 1;
                        } elseif ($max == $highest) {
                            $highest_dates[$hi] = $ob[0];
                            $hi++;
                        }
                        if ($min < $lowest) {
                            $lowest = $min;
                            $lowest_dates = array();
                            $lowest_dates[0] = $ob[0];
                            $li = 1;
                        } elseif ($min == $lowest) {
                            $lowest_dates[$li] = $ob[0];
                            $li++;
                        }
                    }

                    // add that days precip to total precip and add that days snowfall to total snowfall
                    $total_precip += $precip;
                    event(new Alert('create', array('type' => 'info', 'body' => $precip . ": " . $total_precip)));
                    $total_sf += $SF;
                    // test precip, snowfall, and snowdepth if it is greater than certain amounts
                    if ($ob[4] == "T" OR $precip >= 0.01) {
                        $precip_grtrtrace++;
                    }
                    if ($precip >= 0.01) {
                        $grtr01++;
                    }
                    if ($precip >= 0.10) {
                        $grtr10++;
                    }
                    if ($precip >= 0.50) {
                        $grtr50++;
                    }
                    if ($precip >= 1.00) {
                        $grtr100++;
                    }
                    if ($ob[5] == "T" OR $SF >= 0.1) {
                        $sf_grtrtrace++;
                    }
                    if ($SF >= 1) {
                        $sf_grtr1++;
                    }
                    if ($SF >= 3) {
                        $sf_grtr3++;
                    }
                    if ($SF >= 6) {
                        $sf_grtr6++;
                    }
                    if ($SF >= 12) {
                        $sf_grtr12++;
                    }
                    if ($SF >= 18) {
                        $sf_grtr18++;
                    }
                    if ($ob[6] == "T" OR $SD >= 0.1) {
                        $sd_grtrtrace++;
                    }
                    if ($SD >= 1) {
                        $sd_grtr1++;
                    }
                    if ($SD >= 3) {
                        $sd_grtr3++;
                    }
                    if ($SD >= 6) {
                        $sd_grtr6++;
                    }
                    if ($SD >= 12) {
                        $sd_grtr12++;
                    }
                    if ($SD >= 18) {
                        $sd_grtr18++;
                    }
                    if ($count == 0) {
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
                    } else {
                        // compare that days greatest precip, snowfall and snowdepth to
                        // greatest precip, snowfall and snowdepth temp so far
                        if ($precip > $grts_precip) {
                            $grts_precip = $precip;
                            $grts_precip_dates = array();
                            $grts_precip_dates[0] = $ob[0];
                            $GPI = 1;
                        } elseif ($precip == $grts_precip) {
                            $grts_precip_dates[$GPI] = $ob[0];
                            $GPI++;
                        }

                        if ($SF > $grts_SF) {
                            $grts_SF = $SF;
                            $grts_SF_dates = array();
                            $grts_SF_dates[0] = $ob[0];
                            $GSFI = 1;
                        } elseif ($SF == $grts_SF) {
                            $grts_SF_dates[$GSFI] = $ob[0];
                            $GSFI++;
                        }

                        if ($SD > $grts_SD) {
                            $grts_SD = $SD;
                            $grts_SD_dates = array();
                            $grts_SD_dates[0] = $ob[0];
                            $GSDI = 1;
                        } elseif ($SD == $grts_SD) {
                            $grts_SD_dates[$GSDI] = $ob[0];
                            $GSDI++;
                        }
                    }

                    $count++;
                }
                // calculate monthly max and min and average and format them appropriately
                $max_avg = round($max_total / $count, 1);
                $min_avg = round($min_total / $count, 1);
                $avg = round(($max_avg + $min_avg) / 2, 1);


                // find how much monthly average departs from 30 year normals
                $depart_temp_avg = $avg - $AVG_TEMP;


                //find if greatest values are traces
                if ($grts_precip == 0 && $precip_grtrtrace > 0) {
                    $grts_precip = -77;
                    $tempObArray = \App\DailyObs::where('month', $month)->where('year', $year)->get();
                    $datesArray = array();
                    $i = 0;
                    foreach ($tempObArray as $tempOb) {
                        if ($tempOb->precip == -77) {
                            $datesArray[$i] = $tempOb->month . "/" . $tempOb->day . "/" . $tempOb->year;
                            $i++;
                        }
                    }
                    $grts_precip_dates = $datesArray;
                }
                if ($grts_SF == 0 && $sf_grtrtrace > 0) {
                    $grts_SF = -77;
                    $tempObArray = \App\DailyObs::where('month', $month)->where('year', $year)->get();
                    $datesArray = array();
                    $i = 0;
                    foreach ($tempObArray as $tempOb) {
                        if ($tempOb->snowfall == -77) {
                            $datesArray[$i] = $tempOb->month . "/" . $tempOb->day . "/" . $tempOb->year;
                            $i++;
                        }
                    }
                    $grts_SF_dates = $datesArray;
                }
                if ($grts_SD == 0 && $sd_grtrtrace > 0) {
                    $grts_SD = -77;
                    $tempObArray = \App\DailyObs::where('month', $month)->where('year', $year)->get();
                    $datesArray = array();
                    $i = 0;
                    foreach ($tempObArray as $tempOb) {
                        if ($tempOb->snowdepth == -77) {
                            $datesArray[$i] = $tempOb->month . "/" . $tempOb->day . "/" . $tempOb->year;
                            $i++;
                        }
                    }
                    $grts_SD_dates = $datesArray;
                }

                // format all date strings
                $highest_dates_str = "";
                $lowest_dates_str = "";
                $precip_dates_str = "";
                $SF_dates_str = "";
                $SD_dates_str = "";
                $i = 0;
                foreach ($highest_dates as $date) {
                    global $i;
                    $highest_dates_str .= $date;
                    if (isset($highest_dates[$i + 1])) {
                        $highest_dates_str .= ",";
                        $i++;
                    } else {
                        break;
                    }
                }
                $i = 0;
                foreach ($lowest_dates as $date) {
                    global $i;
                    $lowest_dates_str .= $date;
                    if (isset($lowest_dates[$i + 1])) {
                        $lowest_dates_str .= ",";
                        $i++;
                    } else {
                        break;
                    }
                }
                if ($grts_precip != 0) {
                    $i = 0;
                    foreach ($grts_precip_dates as $date) {
                        global $i;
                        $precip_dates_str .= $date;
                        if (isset($grts_precip_dates[$i + 1])) {
                            $precip_dates_str .= ",";
                            $i++;
                        } else {
                            break;
                        }
                    }
                }
                if ($grts_SF != 0) {
                    $i = 0;
                    foreach ($grts_SF_dates as $date) {
                        global $i;
                        $SF_dates_str .= $date;
                        if (isset($grts_SF_dates[$i + 1])) {
                            $SF_dates_str .= ",";
                            $i++;
                        } else {
                            break;
                        }
                    }
                }
                if ($grts_SD != 0) {
                    $i = 0;
                    foreach ($grts_SD_dates as $date) {
                        global $i;
                        $SD_dates_str .= $date;
                        if (isset($grts_SD_dates[$i + 1])) {
                            $SD_dates_str .= ",";
                            $i++;
                        } else {
                            break;
                        }
                    }
                }

                // write to snowseason summary
                if (intval($month) >= 10 && intval($month) <= 12) {
                    if (\App\SnowSeason::where('winter', $year . "-" . strval($year + 1))->count() > 0) {
                        $ssObject = \App\SnowSeason::where('winter', $year . "-" . strval($year + 1))->first();
                        $monthNameSm = strtolower(substr($month_name, 0, 3));
                        if ($ssObject->$monthNameSm == 0) {
                            $ssObject->total = $ssObject->total + ($total_sf == null ? 0 : $total_sf);
                        } else {
                            $ssObject->total = ($ssObject->total - $ssObject->$monthNameSm) + ($total_sf == null ? 0 : $total_sf);
                        }
                        $ssObject->$monthNameSm = ($total_sf == null ? 0 : $total_sf);
                        if ($ssObject->save()) {
                            event(new Alert('create', array('type' => 'info', 'body' => $year . "-" . strval($year + 1) . ' Snow season summary successfully updated.')));
                        } else {
                            event(new Alert('create', array('type' => 'danger', 'body' => 'Snow season summary not successfully updated.')));
                        }
                    } else {
                        $ssObject = new \App\SnowSeason();
                        $monthNameSm = strtolower(substr($month_name, 0, 3));
                        $ssObject->winter = $year . "-" . strval($year + 1);
                        if ($ssObject->$monthNameSm == 0) {
                            $ssObject->total = $ssObject->total + ($total_sf == null ? 0 : $total_sf);
                        } else {
                            $ssObject->total = ($ssObject->total - $ssObject->$monthNameSm) + ($total_sf == null ? 0 : $total_sf);
                        }
                        $ssObject->$monthNameSm = ($total_sf == null ? 0 : $total_sf);
                        if ($ssObject->save()) {
                            event(new Alert('create', array('type' => 'info', 'body' => $year . "-" . strval($year + 1) . ' Snow season summary successfully created.')));
                        } else {
                            event(new Alert('create', array('type' => 'danger', 'body' => 'Snow season summary not successfully created.')));
                        }
                    }
                } else if ($month >= 1 && $month <= 4) {
                    if (\App\SnowSeason::where('winter', strval($year - 1) . "-" . $year)->count() > 0) {
                        $ssObject = \App\SnowSeason::where('winter', strval($year - 1) . "-" . $year)->first();
                        $monthNameSm = strtolower(substr($month_name, 0, 3));
                        if ($ssObject->$monthNameSm == 0) {
                            $ssObject->total = $ssObject->total + ($total_sf == null ? 0 : $total_sf);
                        } else {
                            $ssObject->total = ($ssObject->total - $ssObject->$monthNameSm) + ($total_sf == null ? 0 : $total_sf);
                        }
                        $ssObject->$monthNameSm = ($total_sf == null ? 0 : $total_sf);
                        if ($ssObject->save()) {
                            event(new Alert('create', array('type' => 'info', 'body' => strval($year - 1) . "-" . $year . ' Snow season summary successfully updated.')));
                        } else {
                            event(new Alert('create', array('type' => 'danger', 'body' => 'Snow season summary not successfully updated.')));
                        }
                    } else {
                        $ssObject = new \App\SnowSeason();
                        $monthNameSm = strtolower(substr($month_name, 0, 3));
                        $ssObject->winter = strval($year - 1) . "-" . $year;
                        if ($ssObject->$monthNameSm == 0) {
                            $ssObject->total = $ssObject->total + ($total_sf == null ? 0 : $total_sf);
                        } else {
                            $ssObject->total = ($ssObject->total - $ssObject->$monthNameSm) + ($total_sf == null ? 0 : $total_sf);
                        }
                        $ssObject->$monthNameSm = ($total_sf == null ? 0 : $total_sf);
                        if ($ssObject->save()) {
                            event(new Alert('create', array('type' => 'info', 'body' => strval($year - 1) . "-" . $year . ' Snow season summary successfully created.')));
                        } else {
                            event(new Alert('create', array('type' => 'danger', 'body' => 'Snow season summary not successfully created.')));
                        }
                    }
                }


                //write all monthly values to annuals database table
                if (\App\MonthlyObs::where('month', $month)->where('year', $year)->count() > 0) {
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
                    $monthlyObsObject->total_precip = ($total_precip == null ? 0 : $total_precip);
                    $monthlyObsObject->total_sf = ($total_sf == null ? 0 : $total_sf);
                    $monthlyObsObject->grts_precip = $grts_precip;
                    $monthlyObsObject->grts_precip_dates = $precip_dates_str;
                    $monthlyObsObject->grts_sf = ($grts_SF == null ? 0 : $grts_SF);
                    $monthlyObsObject->grts_sf_dates = $SF_dates_str;
                    $monthlyObsObject->grts_sd = ($grts_SD == null ? 0 : $grts_SD);
                    $monthlyObsObject->grts_sd_dates = $SD_dates_str;
                    $monthlyObsObject->precip_grtrtrace = ($precip_grtrtrace == null ? 0 : $precip_grtrtrace);
                    $monthlyObsObject->grtr01 = ($grtr01 == null ? 0 : $grtr01);
                    $monthlyObsObject->grtr10 = ($grtr10 == null ? 0 : $grtr10);
                    $monthlyObsObject->grtr50 = ($grtr50 == null ? 0 : $grtr50);
                    $monthlyObsObject->grtr100 = ($grtr100 == null ? 0 : $grtr100);
                    $monthlyObsObject->sf_grtrtrace = ($sf_grtrtrace == null ? 0 : $sf_grtrtrace);
                    $monthlyObsObject->sf_grtr1 = ($sf_grtr1 == null ? 0 : $sf_grtr1);
                    $monthlyObsObject->sf_grtr3 = ($sf_grtr3 == null ? 0 : $sf_grtr3);
                    $monthlyObsObject->sf_grtr6 = ($sf_grtr6 == null ? 0 : $sf_grtr6);
                    $monthlyObsObject->sf_grtr12 = ($sf_grtr12 == null ? 0 : $sf_grtr12);
                    $monthlyObsObject->sf_grtr18 = ($sf_grtr18 == null ? 0 : $sf_grtr18);
                    $monthlyObsObject->sd_grtrtrace = ($sd_grtrtrace == null ? 0 : $sd_grtrtrace);
                    $monthlyObsObject->sd_grtr1 = ($sd_grtr1 == null ? 0 : $sd_grtr1);
                    $monthlyObsObject->sd_grtr3 = ($sd_grtr3 == null ? 0 : $sd_grtr3);
                    $monthlyObsObject->sd_grtr6 = ($sd_grtr6 == null ? 0 : $sd_grtr6);
                    $monthlyObsObject->sd_grtr12 = ($sd_grtr12 == null ? 0 : $sd_grtr12);
                    $monthlyObsObject->sd_grtr18 = ($sd_grtr18 == null ? 0 : $sd_grtr18);
                    $monthlyObsObject->remarks = $monthlyObsObject->remarks;
                    $monthlyObsObject->csv_file = $fullpath;
                    if ($monthlyObsObject->save()) {
                        event(new Alert('create', array('type' => 'success', 'body' => 'Summary Successfully Created.')));
                        return redirect()->route('summaries.monthly.view', ['year' => $year, 'month' => $month]);
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
                    $monthlyObsObject->total_precip = ($total_precip == null ? 0 : $total_precip);
                    $monthlyObsObject->total_sf = ($total_sf == null ? 0 : $total_sf);
                    $monthlyObsObject->grts_precip = $grts_precip;
                    $monthlyObsObject->grts_precip_dates = $precip_dates_str;
                    $monthlyObsObject->grts_sf = ($grts_SF == null ? 0 : $grts_SF);
                    $monthlyObsObject->grts_sf_dates = $SF_dates_str;
                    $monthlyObsObject->grts_sd = ($grts_SD == null ? 0 : $grts_SD);
                    $monthlyObsObject->grts_sd_dates = $SD_dates_str;
                    $monthlyObsObject->precip_grtrtrace = ($precip_grtrtrace == null ? 0 : $precip_grtrtrace);
                    $monthlyObsObject->grtr01 = ($grtr01 == null ? 0 : $grtr01);
                    $monthlyObsObject->grtr10 = ($grtr10 == null ? 0 : $grtr10);
                    $monthlyObsObject->grtr50 = ($grtr50 == null ? 0 : $grtr50);
                    $monthlyObsObject->grtr100 = ($grtr100 == null ? 0 : $grtr100);
                    $monthlyObsObject->sf_grtrtrace = ($sf_grtrtrace == null ? 0 : $sf_grtrtrace);
                    $monthlyObsObject->sf_grtr1 = ($sf_grtr1 == null ? 0 : $sf_grtr1);
                    $monthlyObsObject->sf_grtr3 = ($sf_grtr3 == null ? 0 : $sf_grtr3);
                    $monthlyObsObject->sf_grtr6 = ($sf_grtr6 == null ? 0 : $sf_grtr6);
                    $monthlyObsObject->sf_grtr12 = ($sf_grtr12 == null ? 0 : $sf_grtr12);
                    $monthlyObsObject->sf_grtr18 = ($sf_grtr18 == null ? 0 : $sf_grtr18);
                    $monthlyObsObject->sd_grtrtrace = ($sd_grtrtrace == null ? 0 : $sd_grtrtrace);
                    $monthlyObsObject->sd_grtr1 = ($sd_grtr1 == null ? 0 : $sd_grtr1);
                    $monthlyObsObject->sd_grtr3 = ($sd_grtr3 == null ? 0 : $sd_grtr3);
                    $monthlyObsObject->sd_grtr6 = ($sd_grtr6 == null ? 0 : $sd_grtr6);
                    $monthlyObsObject->sd_grtr12 = ($sd_grtr12 == null ? 0 : $sd_grtr12);
                    $monthlyObsObject->sd_grtr18 = ($sd_grtr18 == null ? 0 : $sd_grtr18);
                    $monthlyObsObject->remarks = "";
                    $monthlyObsObject->csv_file = $fullpath;
                    if ($monthlyObsObject->save()) {
                        event(new Alert('create', array('type' => 'success', 'body' => 'Summary Successfully Created.')));
                        return redirect()->route('summaries.monthly.view', ['year' => $year, 'month' => $month]);
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
    public function calcAnnual($year)
    {
        //open 30 year normal file and if it cant be opened; die
        $yr_avg_handle = fopen("./storage/HMPN3-Monthly-Climate-Normals.csv", "r");
        if (!$yr_avg_handle) {
            die("Couldn't read monthly climate normals file.");
        }

        // get 30 year average temp, precip, and snowfall
        $avg_temp_array = fgetcsv($yr_avg_handle);
        $avg_precip_array = fgetcsv($yr_avg_handle);
        $avg_snfl_array = fgetcsv($yr_avg_handle);
        $AVG_TEMP = $avg_temp_array[12];
        $AVG_PRECIP = $avg_precip_array[12];
        $AVG_SNFL = $avg_snfl_array[12];

        //create object array of all the year's observations
        $obs_array = \App\MonthlyObs::where('year', $year)->get();
        if (empty($obs_array) OR $obs_array == NULL) {
            die("Observation doesn't exist.");
        }

        // get all daily obs
        $dailyObs = \App\DailyObs::where('year', $year)->orderBy('month', 'asc')->get();

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
        $total_sf;
        $grts_precip;
        $grts_precip_dates;
        $GPI = 0;
        $grts_sf;
        $grts_sf_dates;
        $GSFI = 0;
        $grts_sd;
        $grts_sd_dates;
        $GSDI = 0;
        $grtr01 = 0;
        $grtr10 = 0;
        $grtr50 = 0;
        $grtr100 = 0;
        $precip_grtrtrace = 0;
        $sf_grtrtrace = 0;
        $sf_grtr1 = 0;
        $sf_grtr3 = 0;
        $sf_grtr6 = 0;
        $sf_grtr12 = 0;
        $sf_grtr18 = 0;
        $SD_grtrtrace = 0;
        $sd_grtr1 = 0;
        $sd_grtr3 = 0;
        $sd_grtr6 = 0;
        $sd_grtr12 = 0;
        $sd_grtr18 = 0;
        // loop through object observation array
        // each loop is another row(month) in the database
        foreach ($obs_array as $ob) {
            // find max and min for that month
            $max = $ob->max_avg;
            $min = $ob->min_avg;

            // find precip, snowfall and snowdepth for that day
            $precip = $ob->total_precip;
            $SF = $ob->total_sf;

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
            global $total_sf;
            global $grts_precip;
            global $grts_precip_dates;
            global $GPI;
            global $grts_sf;
            global $grts_sf_dates;
            global $GSFI;
            global $grts_sd;
            global $grts_sd_dates;
            global $GSDI;
            global $grtr01;
            global $grtr10;
            global $grtr50;
            global $grtr100;
            global $precip_grtrtrace;
            global $sf_grtrtrace;
            global $sf_grtr1;
            global $sf_grtr3;
            global $sf_grtr6;
            global $sf_grtr12;
            global $sf_grtr18;
            global $sd_grtrtrace;
            global $sd_grtr1;
            global $sd_grtr3;
            global $sd_grtr6;
            global $sd_grtr12;
            global $sd_grtr18;

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

            if ($count == 0) {
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
                if ($ob->highest > $highest) {
                    $highest = $ob->highest;
                    $highest_dates = array();
                    $highest_dates[0] = $ob->highest_dates;
                    $hi = 1;
                } elseif ($ob->highest == $highest) {
                    $highest_dates[$hi] = $ob->highest_dates;
                    $hi++;
                }
                if ($ob->lowest < $lowest) {
                    $lowest = $ob->lowest;
                    $lowest_dates = array();
                    $lowest_dates[0] = $ob->lowest_dates;
                    $li = 1;
                } elseif ($ob->lowest == $lowest) {
                    $lowest_dates[$li] = $ob->lowest_dates;
                    $li++;
                }
            }

            // add that months precip to total precip and add that months snowfall to total snowfall
            $total_precip += $precip;
            $total_sf += $SF;

            // add the months extremes to current totals
            $precip_grtrtrace += $ob->precip_grtrtrace;
            $grtr01 += $ob->grtr01;
            $grtr10 += $ob->grtr10;
            $grtr50 += $ob->grtr50;
            $grtr100 += $ob->grtr100;

            $sf_grtrtrace += $ob->sf_grtrtrace;
            $sf_grtr1 += $ob->sf_grtr1;
            $sf_grtr3 += $ob->sf_grtr3;
            $sf_grtr6 += $ob->sf_grtr6;
            $sf_grtr12 += $ob->sf_grtr12;
            $sf_grtr18 += $ob->sf_grtr18;

            $sd_grtrtrace += $ob->sd_grtrtrace;
            $sd_grtr1 += $ob->sd_grtr1;
            $sd_grtr3 += $ob->sd_grtr3;
            $sd_grtr6 += $ob->sd_grtr6;
            $sd_grtr12 += $ob->sd_grtr12;
            $sd_grtr18 += $ob->sd_grtr18;

            if ($count == 0) {
                // set default values for greatest precip, snowfall and snowdepth temps
                $grts_precip = $ob->grts_precip;
                $grts_sf = $ob->grts_sf;
                $grts_sd = $ob->grts_sd;
                $grts_precip_dates[$GPI] = $ob->grts_precip_dates;
                $grts_sf_dates[$GSFI] = $ob->grts_sf_dates;
                $grts_sd_dates[$GSDI] = $ob->grts_sd_dates;
                $GPI++;
                $GSFI++;
                $GSDI++;
                $count++;
                continue;
            } else {
                // compare that months greatest precip, snowfall and snowdepth to
                // greatest precip, snowfall and snowdepth temp so far
                if ($ob->grts_precip > $grts_precip) {
                    $grts_precip = $ob->grts_precip;
                    $grts_precip_dates = array();
                    $grts_precip_dates[0] = $ob->grts_precip_dates;
                    $GPI = 1;
                } elseif ($ob->grts_precip == $grts_precip) {
                    $grts_precip_dates[$GPI] = $ob->grts_precip_dates;
                    $GPI++;
                }

                if ($ob->grts_sf > $grts_sf) {
                    $grts_sf = $ob->grts_sf;
                    $grts_sf_dates = array();
                    $grts_sf_dates[0] = $ob->grts_sf_dates;
                    $GSFI = 1;
                } elseif ($ob->grts_sf == $grts_sf) {
                    $grts_sf_dates[$GSFI] = $ob->grts_sf_dates;
                    $GSFI++;
                }

                if ($ob->grts_sd > $grts_sd) {
                    $grts_sd = $ob->grts_sd;
                    $grts_sd_dates = array();
                    $grts_sd_dates[0] = $ob->grts_sd_dates;
                    $GSDI = 1;
                } elseif ($ob->grts_sd == $grts_sd) {
                    $grts_sd_dates[$GSDI] = $ob->grts_sd_dates;
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
        if (!strpos($MxA_str, ".")) {
            $MxA_str .= ".0";
        }
        if (!strpos($MnA_str, ".")) {
            $MnA_str .= ".0";
        }
        if (!strpos($A_str, ".")) {
            $A_str .= ".0";
        }

        // find how much monthly average departs from 30 year normals
        $depart_temp_avg = $avg - $AVG_TEMP;
        if ($depart_temp_avg > 0) {
            $depart_temp_avg_str = "+" . number_format($depart_temp_avg, 1);
        } else {
            $depart_temp_avg_str = number_format($depart_temp_avg, 1);
        }

        // find how much monthly average departs from 30 year normals for precip and snowfall
        $depart_precip_avg = $total_precip - $AVG_PRECIP;
        if ($depart_precip_avg > 0) {
            $depart_precip_avg_str = "+" . number_format($depart_precip_avg, 2);
        } else {
            $depart_precip_avg_str = number_format($depart_precip_avg, 2);
        }

        $depart_snfl_avg = $total_sf - $AVG_SNFL;
        if ($depart_snfl_avg > 0) {
            $depart_snfl_avg_str = "+" . number_format($depart_snfl_avg, 1);
        } else {
            $depart_snfl_avg_str = number_format($depart_snfl_avg, 1);
        }

        $result = array(
            'year' => $year,
            'monthlyObs' => $obs_array,
            'dailyObs' => $dailyObs,
            'avg_temp_array' => $avg_temp_array,
            'avg_precip_array' => $avg_precip_array,
            'AVG_TEMP' => $AVG_TEMP,
            'AVG_PRECIP' => $AVG_PRECIP,
            'AVG_SNFL' => $AVG_SNFL,
            'max_avg' => $max_avg,
            'min_avg' => $min_avg,
            'avg' => $avg,
            'MxA_str' => $MxA_str,
            'MnA_str' => $MnA_str,
            'A_str' => $A_str,
            'depart_temp_avg_str' => $depart_temp_avg_str,
            'highest' => $highest,
            'highest_dates' => $highest_dates,
            'lowest' => $lowest,
            'lowest_dates' => $lowest_dates,
            'hdd_count' => $hdd_count,
            'cdd_count' => $cdd_count,
            'max_over90' => $max_over90,
            'max_below32' => $max_below32,
            'min_below0' => $min_below0,
            'min_below32' => $min_below32,
            'total_precip' => $total_precip,
            'total_sf' => $total_sf,
            'grts_precip' => $grts_precip,
            'grts_precip_dates' => $grts_precip_dates,
            'depart_precip_avg_str' => $depart_precip_avg_str,
            'grts_sf' => $grts_sf,
            'grts_sf_dates' => $grts_sf_dates,
            'depart_snfl_avg_str' => $depart_snfl_avg_str,
            'grts_sd' => $grts_sd,
            'grts_sd_dates' => $grts_sd_dates,
            'grtr01' => $grtr01,
            'grtr10' => $grtr10,
            'grtr50' => $grtr50,
            'grtr100' => $grtr100,
            'precip_grtrtrace' => $precip_grtrtrace,
            'sf_grtrtrace' => $sf_grtrtrace,
            'sf_grtr1' => $sf_grtr1,
            'sf_grtr3' => $sf_grtr3,
            'sf_grtr6' => $sf_grtr6,
            'sf_grtr12' => $sf_grtr12,
            'sf_grtr18' => $sf_grtr18,
            'sd_grtrtrace' => $sd_grtrtrace,
            'sd_grtr1' => $sd_grtr1,
            'sd_grtr3' => $sd_grtr3,
            'sd_grtr6' => $sd_grtr6,
            'sd_grtr12' => $sd_grtr12,
            'sd_grtr18' => $sd_grtr18
        );
        return $result;
    }


    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function handleFile()
    {
        if (\Input::file('files')->isValid()) {
            echo "swag";
        }
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showMonthlyHome()
    {
        return view('summaries.monthly.view');
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showMonthlySummary(Request $request, $year, $month)
    {
        // get summary
        $summary = \App\MonthlyObs::where('month', $month)->where('year', $year)->first();

        // find precip to date
        $allSummaries = \App\MonthlyObs::where('year', $year)->get();
        $precip_toDate = 0;
        foreach ($allSummaries as $result) {
            $precip_toDate += $result->total_precip;
        }

        //open 30 year normal file and if it cant be opened; die
        $yr_avg_handle = fopen("./storage/HMPN3-Monthly-Climate-Normals.csv", "r");
        if (!$yr_avg_handle) {
            die("Couldn't read monthly climate normals file.");
        }

        // get all daily obs
        $dailyObs = \App\DailyObs::where('month', $month)->where('year', $year)->get();

        // get 30 year average temp, precip, and snowfall
        $avg_temp_array = fgetcsv($yr_avg_handle);
        $avg_precip_array = fgetcsv($yr_avg_handle);
        $avg_snfl_array = fgetcsv($yr_avg_handle);
        $AVG_TEMP = $avg_temp_array[$month - 1];
        $AVG_PRECIP = $avg_precip_array[$month - 1];
        $AVG_SNFL = $avg_snfl_array[$month - 1];

        return view('summaries.monthly.view', ['summary' => $summary, 'dailyObs' => $dailyObs, 'AVG_TEMP' => $AVG_TEMP, 'AVG_PRECIP' => $AVG_PRECIP, 'AVG_SNFL' => $AVG_SNFL, 'precip_toDate' => $precip_toDate]);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showTextMonthlySummary(Request $request, $year, $month)
    {
        // get summary
        $summary = \App\MonthlyObs::where('month', $month)->where('year', $year)->first();

        //open 30 year normal file and if it cant be opened; die
        $yr_avg_handle = fopen("./storage/HMPN3-Monthly-Climate-Normals.csv", "r");
        if (!$yr_avg_handle) {
            die("Couldn't read monthly climate normals file.");
        }

        // find precip to date
        $allSummaries = \App\MonthlyObs::where('year', $year)->get();
        $precip_toDate = 0;
        foreach ($allSummaries as $result) {
            $precip_toDate += $result->total_precip;
        }

        // get 30 year average temp, precip, and snowfall
        $avg_temp_array = fgetcsv($yr_avg_handle);
        $avg_precip_array = fgetcsv($yr_avg_handle);
        $avg_snfl_array = fgetcsv($yr_avg_handle);
        $AVG_TEMP = $avg_temp_array[$month - 1];
        $AVG_PRECIP = $avg_precip_array[$month - 1];
        $AVG_SNFL = $avg_snfl_array[$month - 1];

        return view('summaries.monthly.text', ['summary' => $summary, 'AVG_TEMP' => $AVG_TEMP, 'AVG_PRECIP' => $AVG_PRECIP, 'AVG_SNFL' => $AVG_SNFL, 'precip_toDate' => $precip_toDate]);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function downloadMonthlyHTML(Request $request, $year, $month)
    {
        // get summary
        $summary = \App\MonthlyObs::where('month', $month)->where('year', $year)->first();

        //open 30 year normal file and if it cant be opened; die
        $yr_avg_handle = fopen("./storage/HMPN3-Monthly-Climate-Normals.csv", "r");
        if (!$yr_avg_handle) {
            die("Couldn't read monthly climate normals file.");
        }

        // find precip to date
        $allSummaries = \App\MonthlyObs::where('year', $year)->get();
        $precip_toDate = 0;
        foreach ($allSummaries as $result) {
            $precip_toDate += $result->total_precip;
        }

        // get 30 year average temp, precip, and snowfall
        $avg_temp_array = fgetcsv($yr_avg_handle);
        $avg_precip_array = fgetcsv($yr_avg_handle);
        $avg_snfl_array = fgetcsv($yr_avg_handle);
        $AVG_TEMP = $avg_temp_array[$month - 1];
        $AVG_PRECIP = $avg_precip_array[$month - 1];
        $AVG_SNFL = $avg_snfl_array[$month - 1];

        $view = \View::make('summaries.monthly.text', ['summary' => $summary, 'AVG_TEMP' => $AVG_TEMP, 'AVG_PRECIP' => $AVG_PRECIP, 'AVG_SNFL' => $AVG_SNFL, 'precip_toDate' => $precip_toDate]);
        $contents = $view->render();

        //PDF file is stored under project/public/download/info.pdf
        $headers = array(
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="West_Hampstead-' . $year . '_' . $month . '-MonthlySummary.html"'
        );
        return \Response::make($contents, 200, $headers);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function downloadMonthlyPDF(Request $request, $year, $month)
    {
        // get summary
        $summary = \App\MonthlyObs::where('month', $month)->where('year', $year)->first();

        //open 30 year normal file and if it cant be opened; die
        $yr_avg_handle = fopen("./storage/HMPN3-Monthly-Climate-Normals.csv", "r");
        if (!$yr_avg_handle) {
            die("Couldn't read monthly climate normals file.");
        }

        // find precip to date
        $allSummaries = \App\MonthlyObs::where('year', $year)->get();
        $precip_toDate = 0;
        foreach ($allSummaries as $result) {
            $precip_toDate += $result->total_precip;
        }

        // get 30 year average temp, precip, and snowfall
        $avg_temp_array = fgetcsv($yr_avg_handle);
        $avg_precip_array = fgetcsv($yr_avg_handle);
        $avg_snfl_array = fgetcsv($yr_avg_handle);
        $AVG_TEMP = $avg_temp_array[$month - 1];
        $AVG_PRECIP = $avg_precip_array[$month - 1];
        $AVG_SNFL = $avg_snfl_array[$month - 1];

        $pdf = \Barryvdh\DomPDF\Facade::loadView('summaries.monthly.text', ['summary' => $summary, 'AVG_TEMP' => $AVG_TEMP, 'AVG_PRECIP' => $AVG_PRECIP, 'AVG_SNFL' => $AVG_SNFL, 'precip_toDate' => $precip_toDate]);
        return $pdf->download('West_Hampstead-' . $year . '_' . $month . '-MonthlySummary.pdf');
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function downloadMonthlyCSV(Request $request, $year, $month)
    {
        // get summary
        $summary = \App\MonthlyObs::where('month', $month)->where('year', $year)->first();

        // get contents of csv files
        $csv = file_get_contents($summary->csv_file);

        // create headers and download file
        $headers = array(
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="West_Hampstead-' . $year . '_' . $month . '.csv"'
        );
        return \Response::make($csv, 200, $headers);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function editMonthlyRemarks(Request $request, $year, $month)
    {
        $remarks = strip_tags(\Input::get('remarks'), '<p><a><h5><b><i><ul><li><br>');
        $password = \Input::get('password');

        if ($password == 'cfs613') {
            $monthlyObsObject = \App\MonthlyObs::where('month', $month)->where('year', $year)->first();
            $monthlyObsObject->remarks = $remarks;
            if ($monthlyObsObject->save()) {
                event(new Alert('create', array('type' => 'success', 'body' => 'Remarks Successfully Saved.')));
                return redirect()->route('summaries.monthly.view', ['year' => $year, 'month' => $month]);
            } else {
                event(new Alert('create', array('type' => 'danger', 'body' => 'Remarks Not Successfully Created.')));
                return redirect()->route('summaries.monthly.view', ['year' => $year, 'month' => $month]);
            }
        }
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showAnnualHome()
    {
        if (!isset($year) || is_null($year) || empty($year)) {
            $data = array('year' => null);
        } else {
            $data = $this->calcAnnual($year);
        }

        return view('summaries.annual.view', $data);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showAnnualSummary(Request $request, $year)
    {
        if (!isset($year) || is_null($year) || empty($year)) {
            $data = array('year' => null);
        } else {
            $data = $this->calcAnnual($year);
        }

        return view('summaries.annual.view', $data);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showTextAnnualSummary(Request $request, $year)
    {
        $data = $this->calcAnnual($year);

        return view('summaries.annual.text', $data);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function downloadAnnualPDF(Request $request, $year)
    {
        if (!isset($year) || is_null($year) || empty($year)) {
            $data = array('year' => null);
        } else {
            $data = $this->calcAnnual($year);
        }

        $pdf = \Barryvdh\DomPDF\Facade::loadView('summaries.annual.text', $data);
        return $pdf->download('West_Hampstead-' . $year . '-AnnualSummary.pdf');
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function downloadAnnualHTML(Request $request, $year)
    {
        if (!isset($year) || is_null($year) || empty($year)) {
            $data = array('year' => null);
        } else {
            $data = $this->calcAnnual($year);
        }

        $view = \View::make('summaries.annual.text', $data);
        $contents = $view->render();

        //PDF file is stored under project/public/download/info.pdf
        $headers = array(
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="West_Hampstead-' . $year . '-AnnualSummary.html"'
        );
        return \Response::make($contents, 200, $headers);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showSnowSeasonView()
    {
        $allSummaries = \App\SnowSeason::orderBy('winter')->get();

        return view('summaries.snowseason.view', ['summaries' => $allSummaries]);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showSnowSeasonWinterView(Request $request, $winter)
    {
        $summary = \App\SnowSeason::where('winter', $winter)->first();

        return view('summaries.snowseason.winter', ['summary' => $summary]);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showPeakFoliageView()
    {
        $allPeaks = \App\PeakFoliage::orderBy('year')->get();

        return view('summaries.peakfoliage.view', ['allPeaks' => $allPeaks]);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showPeakFoliageSubmit()
    {
        return view('summaries.peakfoliage.submit');
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function submitPeakFoliage()
    {
        if (\Input::get('password') == "cfs613") {
            if (\App\PeakFoliage::where('year', \Input::get('year'))->count() > 0) {
                $eventObject = \App\PeakFoliage::where('year', \Input::get('year'))->first();
                $eventObject->year = trim(\Input::get('year'));
                $eventObject->date = trim(\Input::get('date'));

                if ($eventObject->save()) {
                    event(new Alert('create', array('type' => 'success', 'body' => 'Peak Foliage submitted successfully.')));
                    return redirect()->route('summaries.peakfoliage.view');
                } else {
                    event(new Alert('create', array('type' => 'danger', 'body' => 'Peak Foliage not submitted successfully.')));
                    return redirect()->route('summaries.peakfoliage.submit');
                }
            } else {
                $eventObject = new \App\PeakFoliage;
                $eventObject->year = trim(\Input::get('year'));
                $eventObject->date = trim(\Input::get('date'));

                if ($eventObject->save()) {
                    event(new Alert('create', array('type' => 'success', 'body' => 'Peak Foliage submitted successfully.')));
                    return redirect()->route('summaries.peakfoliage.view');
                } else {
                    event(new Alert('create', array('type' => 'danger', 'body' => 'Peak Foliage not submitted successfully.')));
                    return redirect()->route('summaries.peakfoliage.submit');
                }
            }
        } else {
            event(new Alert('create', array('type' => 'danger', 'body' => 'Incorrect password.')));
            return redirect()->route('summaries.peakfoliage.submit');
        }
    }


    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showSunsetLakeView()
    {
        $allSummaries = \App\IceInIceOut::orderBy('season')->get();

        return view('summaries.sunsetlake.view', ['summaries' => $allSummaries]);
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function showSunsetLakeSubmit()
    {
        return view('summaries.sunsetlake.submit');
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function submitIceInIceOut()
    {
        if (\Input::get('password') == "cfs613") {
            if (\App\IceInIceOut::where('season', \Input::get('season'))->count() > 0) {
                $eventObject = \App\IceInIceOut::where('season', \Input::get('season'))->first();
                $eventObject->season = trim(\Input::get('season'));
                $eventObject->icein = trim(\Input::get('icein'));
                $eventObject->iceout = trim(\Input::get('iceout'));

                $start_date = new \DateTime(trim(\Input::get('icein')));
                $end_date = new \DateTime(trim(\Input::get('iceout')));

                $dd = date_diff($end_date, $start_date);
                $eventObject->duration = $dd->d;

                if ($eventObject->save()) {
                    event(new Alert('create', array('type' => 'success', 'body' => 'Ice In/Ice Out submitted successfully.')));
                    return redirect()->route('summaries.sunsetlake.view');
                } else {
                    event(new Alert('create', array('type' => 'danger', 'body' => 'Ice In/Ice Out not submitted successfully.')));
                    return redirect()->route('summaries.sunsetlake.submit');
                }
            } else {
                $eventObject = new \App\IceInIceOut;
                $eventObject->season = trim(\Input::get('season'));
                $eventObject->icein = trim(\Input::get('icein'));
                $eventObject->iceout = trim(\Input::get('iceout'));

                $start_date = new \DateTime(trim(\Input::get('icein')));
                $end_date = new \DateTime(trim(\Input::get('iceout')));

                $dd = date_diff($end_date, $start_date);
                $eventObject->duration = $dd->d;

                if ($eventObject->save()) {
                    event(new Alert('create', array('type' => 'success', 'body' => 'Ice In/Ice Out submitted successfully.')));
                    return redirect()->route('summaries.sunsetlake.view');
                } else {
                    event(new Alert('create', array('type' => 'danger', 'body' => 'Ice In/Ice Out not submitted successfully.')));
                    return redirect()->route('summaries.sunsetlake.submit');
                }
            }
        } else {
            event(new Alert('create', array('type' => 'danger', 'body' => 'Incorrect password.')));
            return redirect()->route('summaries.sunsetlake.submit');
        }
    }
}
