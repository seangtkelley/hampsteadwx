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
Route::get('sitemap',                         ['uses'=>'HomeController@sitemap','index'=>false]);

/*
 * Welcome Page
 * */
Route::get('/',                               ['as' => 'index', 'uses'=>'HomeController@showWelcome','index'=>true]);
Route::get('/home',                           ['as' => 'home', 'uses'=>'HomeController@showWelcome','index'=>true]);

/*
 * Observations
 * */
Route::get('/monthlySummary',                 ['as' => 'summaries.monthly.home', 'uses'=>'SummaryController@showMonthly','index'=>true]);
Route::get('/monthlySummary/{month}/{year}',  ['as' => 'summaries.monthly.specific', 'uses'=>'SummaryController@showMonthly','index'=>true]);

Route::get('/submitSummary',                  ['as' => 'summaries.submit', 'uses'=>'SummaryController@showSubmit','index'=>true]);
Route::post('/submitSummary',                 ['as' => 'summaries.submit', 'uses'=>'SummaryController@calcSummary','index'=>false]);
Route::post('/submitSummary/HandleFile',      ['as' => 'summaries.submit.handleFile', 'uses'=>'SummaryController@handleFile','index'=>false]);
