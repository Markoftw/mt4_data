<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get("/", ["as" => "mt4_index", "uses" => "MT4Controller@index"]);
Route::get("/data/history", ["as" => "mt4_history", "uses" => "MT4Controller@getHistoryData"]);
Route::get("/data/signals", ["as" => "mt4_data", "uses" => "MT4Controller@getData"]);
Route::get("/update/one", ["as" => "mt4_update_one", "uses" => "MT4Controller@calculate_one"]);
Route::get("/update", ["as" => "mt4_update", "uses" => "MT4Controller@calculate"]);
Route::get("/test", ["as" => "tests", "uses" => "MT4Controller@tests"]);
Route::get("/get/history/{pair}", ["as" => "mt4_check_history", "uses" => "MT4Controller@checkHistory"]);
Route::post("/store/history", ["as" => "store_history", "uses" => "MT4Controller@storeHistory"]);
Route::post("/store/setting", ["as" => "store_setting", "uses" => "MT4Controller@storeSetting"]);

Route::get("/history", ["as" => "mt4_history_index", "uses" => "SignalsController@index"]);
Route::get("/data/history/signals", ["as" => "mt4_history_signals", "uses" => "SignalsController@getData"]);
Route::post("/store/history/signals", ["as" => "store_history_signals", "uses" => "SignalsController@store"]);

Route::get("/force-refresh/{reason}", ["as" => "force_refresh", "uses" => "SettingsController@send_refresh"]);
