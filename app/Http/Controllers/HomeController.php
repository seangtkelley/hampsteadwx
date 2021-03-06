<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class HomeController extends Controller{
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
    public function showWelcome($locale=null){
        if($locale != null){
            \App::setLocale($locale);
        }
        return view('welcome');
    }

    /**
     * Show the welcome view and set the locale
     *
     * @param string $locale
     * @return mixed
     */
    public function showInfo($locale=null){
        return view('info');
    }

    /**
     * Show the welcome view and set the locale
     *
     * @param string $locale
     * @return mixed
     */
    public function showNormals($locale=null){
        return view('normals');
    }

    /**
     * Generate a sitemap based on the routes
     *
     * @return mixed
     */
    public function sitemap(){
        $yesterday = new Carbon('yesterday');
        $lastWeek = new Carbon('last week');
        $lastMonth = new Carbon('last month');

        $sitemap = \App::make("sitemap");

        $routeCollection = \Route::getRoutes();

        $dynamicReg = "/{\\S*}/"; //used for omitting dynamic urls that have {} in uri

        foreach ($routeCollection as $route) {
            if(!preg_match($dynamicReg,$route->getUri()) &&
                /*!blacklisted($route->getUri()) &&*/
                in_array('GET',$route->getMethods()) &&
                (isset($route->getAction()['index']) &&
                    $route->getAction()['index']!==false)
            ){

                //happy with this url, add it to sitemap
                $sitemap->add(\URL::to($route->getUri()), $lastWeek , '1.0', 'daily');

            }
        }

        // Now, output the sitemap:
        return $sitemap->render('xml');
    }
}
