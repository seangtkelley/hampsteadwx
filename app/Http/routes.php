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
Route::get('sitemap',                                 ['uses'=>'HomeController@sitemap','index'=>false]);

/*
 * Welcome Page
 * */
Route::get('/',                                       ['as' => 'index', 'uses'=>'HomeController@showWelcome','index'=>true]);
Route::get('/home',                                   ['as' => 'home', 'uses'=>'HomeController@showWelcome','index'=>true]);

/*
 * Observations
 * */
Route::get('/summaries/monthly',                      ['as' => 'summaries.monthly.home', 'uses'=>'SummaryController@showMonthlyHome','index'=>true]);
Route::get('/summaries/monthly/{year}/{month}',       ['as' => 'summaries.monthly.view', 'uses'=>'SummaryController@showMonthlySummary','index'=>true]);
Route::get('/summaries/monthly/raw/{year}/{month}',   ['as' => 'summaries.monthly.raw',  'uses'=>'SummaryController@showRawMonthlySummary','index'=>true]);

Route::get('/summaries/submit',                       ['as' => 'summaries.submit', 'uses'=>'SummaryController@showSubmit','index'=>false]);
Route::post('/summaries/submit',                      ['as' => 'summaries.submit', 'uses'=>'SummaryController@calcSummary','index'=>false]);
Route::post('/summaries/submit/HandleFile',           ['as' => 'summaries.submit.handleFile', 'uses'=>'SummaryController@handleFile','index'=>false]);
