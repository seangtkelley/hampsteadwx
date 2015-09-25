<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
    public function showSubmit(){
        return view('summaries.submit');
    }

    /**
     * Handle the event.
     *
     * @param string $locale
     * @return mixed
     */
    public function calcSummary(){
      $year  = \Input::get('year');
      $month = \Input::get('month');

      if (\Input::file('csvFile')->isValid())
      {
        $destinationPath = "./";
        $fileName = "West_Hampstead-" . $year . "_" . $month . ".csv";
        echo $fileName;
        \Input::file('csvFile')->move($destinationPath, $fileName);
      }
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
    public function showMonthly(){
        return view('summaries.monthly');
    }

}
