<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PhotosController extends Controller{
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
    public function showPhotosHome(){
        return view('photos.home');
    }

    /**
     * Show the welcome view and set the locale
     *
     * @param string $locale
     * @return mixed
     */
    public function showPhotosSubmit(){
        return view('photos.submit');
    }

    /**
     * Show the welcome view and set the locale
     *
     * @param string $locale
     * @return mixed
     */
    public function submitPhoto(){
        return redirect()->route('photos.home');
    }
}
