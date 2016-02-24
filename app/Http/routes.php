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
 * Basic Pages
 * */
Route::get('/',                                       ['as' => 'index', 'uses'=>'HomeController@showWelcome','index'=>true]);
Route::get('/home',                                   ['as' => 'home', 'uses'=>'HomeController@showWelcome','index'=>true]);
Route::get('/info',                                   ['as' => 'info', 'uses'=>'HomeController@showInfo','index'=>true]);
Route::get('/normals',                                ['as' => 'normals', 'uses'=>'HomeController@showNormals','index'=>true]);

/*
 * Observations
 * */
 Route::get('/summaries/monthly/submit',               ['as' => 'summaries.monthly.submit', 'uses'=>'SummaryController@showMonthlySubmit','index'=>false]);
 Route::post('/summaries/monthly/submit',              ['as' => 'summaries.monthly.submit', 'uses'=>'SummaryController@calcMonthly','index'=>false]);
 Route::get('/summaries/annual/submit',                ['as' => 'summaries.annual.submit', 'uses'=>'SummaryController@showAnnualSubmit','index'=>false]);
 Route::post('/summaries/annual/submit',               ['as' => 'summaries.annual.submit', 'uses'=>'SummaryController@calcAnnual','index'=>false]);
 Route::post('/summaries/submit/HandleFile',           ['as' => 'summaries.submit.handleFile', 'uses'=>'SummaryController@handleFile','index'=>false]);

Route::get('/summaries/monthly',                      ['as' => 'summaries.monthly.home', 'uses'=>'SummaryController@showMonthlyHome','index'=>true]);
Route::get('/summaries/monthly/{year}/{month}',       ['as' => 'summaries.monthly.view', 'uses'=>'SummaryController@showMonthlySummary','index'=>true]);
Route::get('/summaries/monthly/raw/{year}/{month}',   ['as' => 'summaries.monthly.raw',  'uses'=>'SummaryController@showRawMonthlySummary','index'=>true]);

Route::get('/summaries/annual',                       ['as' => 'summaries.annual.home', 'uses'=>'SummaryController@showAnnualHome','index'=>true]);
Route::get('/summaries/annual/{year}',                ['as' => 'summaries.annual.view', 'uses'=>'SummaryController@showAnnualSummary','index'=>true]);
Route::get('/summaries/annual/raw/{year}',            ['as' => 'summaries.annual.raw',  'uses'=>'SummaryController@showRawAnnualSummary','index'=>true]);
