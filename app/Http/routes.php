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
 * Summaries
 * */
Route::get('/summaries/monthly/submit',               ['as' => 'summaries.monthly.submit', 'uses'=>'SummaryController@showMonthlySubmit','index'=>false]);
Route::post('/summaries/monthly/submit',              ['as' => 'summaries.monthly.submit', 'uses'=>'SummaryController@calcMonthly','index'=>false]);
Route::post('/summaries/submit/HandleFile',           ['as' => 'summaries.submit.handleFile', 'uses'=>'SummaryController@handleFile','index'=>false]);

Route::get('/summaries/monthly',                      ['as' => 'summaries.monthly.home', 'uses'=>'SummaryController@showMonthlyHome','index'=>true]);
Route::get('/summaries/monthly/{year}/{month}',       ['as' => 'summaries.monthly.view', 'uses'=>'SummaryController@showMonthlySummary','index'=>true]);
Route::get('/summaries/monthly/{year}/{month}/text',  ['as' => 'summaries.monthly.text',  'uses'=>'SummaryController@showTextMonthlySummary','index'=>true]);
Route::get('/summaries/monthly/{year}/{month}/csv',   ['as' => 'summaries.monthly.csv', 'uses'=>'SummaryController@downloadMonthlyCSV','index'=>false]);
Route::get('/summaries/monthly/{year}/{month}/pdf',   ['as' => 'summaries.monthly.pdf',  'uses'=>'SummaryController@downloadMonthlyPDF','index'=>false]);
Route::get('/summaries/monthly/{year}/{month}/html',  ['as' => 'summaries.monthly.html', 'uses'=>'SummaryController@downloadMonthlyHTML','index'=>false]);
Route::post('/summaries/monthly/{year}/{month}/editRemarks',   ['as' => 'summaries.monthly.editRemarks',  'uses'=>'SummaryController@editMonthlyRemarks','index'=>false]);

Route::get('/summaries/annual',                       ['as' => 'summaries.annual.home', 'uses'=>'SummaryController@showAnnualHome','index'=>true]);
Route::get('/summaries/annual/{year}',                ['as' => 'summaries.annual.view', 'uses'=>'SummaryController@showAnnualSummary','index'=>true]);
Route::get('/summaries/annual/{year}/text',           ['as' => 'summaries.annual.text',  'uses'=>'SummaryController@showTextAnnualSummary','index'=>true]);
Route::get('/summaries/annual/{year}/html',           ['as' => 'summaries.annual.html', 'uses'=>'SummaryController@downloadAnnualHTML','index'=>false]);
Route::get('/summaries/annual/{year}/pdf',            ['as' => 'summaries.annual.pdf',  'uses'=>'SummaryController@downloadAnnualPDF','index'=>false]);

Route::get('/summaries/snowseason',                   ['as' => 'summaries.snowseason.view', 'uses'=>'SummaryController@showSnowSeasonView','index'=>true]);
Route::get('/summaries/snowseason/{winter}',          ['as' => 'summaries.snowseason.winter', 'uses'=>'SummaryController@showSnowSeasonWinterView','index'=>true]);

Route::get('/summaries/peakfoliage',                  ['as' => 'summaries.peakfoliage.view', 'uses'=>'SummaryController@showPeakFoliageView','index'=>true]);
Route::get('/summaries/peakfoliage/submit',           ['as' => 'summaries.peakfoliage.submit', 'uses'=>'SummaryController@showPeakFoliageSubmit','index'=>false]);
Route::post('/summaries/peakfoliage/submit',          ['as' => 'summaries.peakfoliage.submit', 'uses'=>'SummaryController@submitPeakFoliage','index'=>false]);

Route::get('/summaries/sunsetlake',                   ['as' => 'summaries.sunsetlake.view', 'uses'=>'SummaryController@showSunsetLakeView','index'=>true]);
Route::get('/summaries/sunsetlake/submit',            ['as' => 'summaries.sunsetlake.submit', 'uses'=>'SummaryController@showSunsetLakeSubmit','index'=>false]);
Route::post('/summaries/sunsetlake/submit',           ['as' => 'summaries.sunsetlake.submit', 'uses'=>'SummaryController@submitIceInIceOut','index'=>false]);

Route::get('/summaries/precip',                       ['as' => 'summaries.precip.view', 'uses'=>'SummaryController@showPrecipView','index'=>true]);

/*
 * Events
 * */
Route::get('/events',                                 ['as' => 'events.home', 'uses'=>'EventsController@showEventsHome','index'=>true]);
Route::get('/events/submit',                          ['as' => 'events.submit', 'uses'=>'EventsController@showEventsSubmit','index'=>false]);
Route::post('/events/submit',                         ['as' => 'events.submit', 'uses'=>'EventsController@submitEvent','index'=>false]);

 /*
  * Photos
  * */
Route::get('/photos',                                 ['as' => 'photos.home', 'uses'=>'PhotosController@showPhotosHome','index'=>true]);
Route::get('/photos/submit',                          ['as' => 'photos.submit', 'uses'=>'PhotosController@showPhotosSubmit','index'=>false]);
Route::post('/photos/submit',                         ['as' => 'photos.submit', 'uses'=>'PhotosController@submitPhoto','index'=>false]);
