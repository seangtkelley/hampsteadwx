<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
| 'index'=>true  : include route  in  sitemap
| 'index'=>false : exclude route from sitemap
*/

/*
 * Sitemap
 */
Route::get('sitemap', array('uses'=>'HomeController@sitemap','index'=>false));

/*
 * Welcome Page
 * */
Route::get('/', ['as' => 'index', 'uses'=>'HomeController@showWelcome','index'=>true]);
Route::get('/home', ['as' => 'home', 'uses'=>'HomeController@showWelcome','index'=>true]);

/*
 * Observations
 * */
Route::get('/monthlyObs', ['as' => 'monthlyDefault', 'uses'=>'ObsController@showMonthly','index'=>true]);
Route::get('/monthlyObs/{month}/{year}', ['as' => 'monthlySpecific', 'uses'=>'ObsController@showMonthly','index'=>true]);
