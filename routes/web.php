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

Route::get("/test", ["as" => "tests", "uses" => "TestController@index"]);
Route::get("/update/one", ["as" => "mt4_update_one", "uses" => "TestController@calculate_one"]);

Route::get("/", ["as" => "mt4_index", "uses" => "MT4Controller@index"]);
Route::get("/data/history", ["as" => "mt4_history", "uses" => "MT4Controller@getHistoryData"]);
Route::get("/data/signals", ["as" => "mt4_data", "uses" => "MT4Controller@getData"]);
Route::get("/update", ["as" => "mt4_update", "uses" => "MT4Controller@calculate"]);
Route::get("/get/history/{pair}", ["as" => "mt4_check_history", "uses" => "MT4Controller@checkHistory"]);

Route::get("/history", ["as" => "mt4_history_index", "uses" => "SignalsController@index"]);
Route::get("/data/history/signals", ["as" => "mt4_history_signals", "uses" => "SignalsController@getData"]);
Route::post("/store/history/signals", ["as" => "store_history_signals", "uses" => "SignalsController@store"]);

Route::get("/force-refresh/{reason}", ["as" => "force_refresh", "uses" => "SettingsController@send_refresh"]);
Route::post("/store/setting", ["as" => "store_setting", "uses" => "SettingsController@storeSetting"]);
Route::post("/store/notifications", ["as" => "store_notifications", "uses" => "SettingsController@storeNotifications"]);
