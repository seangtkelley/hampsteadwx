<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Events\Alert;
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
      if(\Input::get('password') == getenv('SITE_PASS')){
        $eventObject = new \App\Events;
        $eventObject->type = trim(\Input::get('type'));
        $eventObject->startdate = trim(\Input::get('startdate'));
        $eventObject->enddate = trim(\Input::get('enddate'));
        $eventObject->description = trim(\Input::get('description'));

        if($eventObject->save()){
          event(new Alert('create', array('type' => 'success', 'body' => 'Event submitted successfully.')));
          return redirect()->route('events.submit');
        } else {
          event(new Alert('create', array('type' => 'danger', 'body' => 'Event not submitted successfully.')));
          return redirect()->route('events.submit');
        }
      } else {
        event(new Alert('create', array('type' => 'danger', 'body' => 'Incorrect password.')));
        return redirect()->route('events.submit');
      }
    }
}
