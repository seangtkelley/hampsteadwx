<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class EventsController extends Controller{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the display of the welcome page
    |
    */

    /**
     * Show the welcome view and set the locale
     *
     * @param string $locale
     * @return mixed
     */
    public function showEventsHome(){
        return view('events.home');
    }

    /**
     * Show the welcome view and set the locale
     *
     * @param string $locale
     * @return mixed
     */
    public function showEventsSubmit(){
        return view('events.submit');
    }

    /**
     * Show the welcome view and set the locale
     *
     * @param string $locale
     * @return mixed
     */
    public function submitEvent(){
        return redirect()->route('events.home');
    }
}
