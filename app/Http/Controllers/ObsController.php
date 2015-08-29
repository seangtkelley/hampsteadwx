<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ObsController extends Controller{
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
    public function showMonthly(){
        return view('obs.monthly');
    }

}
