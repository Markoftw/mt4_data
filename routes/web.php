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
Route::get("/history", ["as" => "mt4_history", "uses" => "MT4Controller@history"]);

Route::get("/data", ["as" => "mt4_data", "uses" => "MT4Controller@getData"]);
Route::get("/update/one", ["as" => "mt4_update_one", "uses" => "MT4Controller@calculate_one"]);
Route::get("/update", ["as" => "mt4_update", "uses" => "MT4Controller@calculate"]);
