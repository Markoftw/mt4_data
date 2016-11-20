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

Route::get('/test', [
    'as' => 'test',
    function () {

        $arrows = \App\Arrow::with('pair')->get()->toJson();

        event(new \App\Events\SendForexData($arrows));

    }
]);
