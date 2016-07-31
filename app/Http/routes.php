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
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/

//Quotes Page
Route::get('/', 'HistoricalQuotes@show');

//Form request:: POST action will trigger to controller
Route::post('quotes_request','HistoricalQuotes@search');

//Form request:: GET action will trigger to controller
Route::get('quotes_request','HistoricalQuotes@search');
