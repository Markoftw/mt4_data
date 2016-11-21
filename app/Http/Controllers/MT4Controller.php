<?php

namespace App\Http\Controllers;

use App\Events\SendForexData;
use Illuminate\Http\Request;
use App\Arrow;
use App\CStrength;
use App\Data;
use App\History;
use App\Pair;
use App\Price;
use App\Signal;

class MT4Controller extends Controller
{

    public function index()
    {
        return view('forex_table');
    }

    public function history()
    {
        return view('forex_table_history');
    }

    public function getData()
    {
        $signals = Signal::with('pair')->get()->toArray();

        return $signals;

    }

    public function calculate_one()
    {

        //$signal = ["id"=>1,"pair_id"=>1,"cs_signal"=>"NO","p_m5"=>"BUY","p_m15"=>"SELL","p_m30"=>"SELL","p_h1"=>"SELL","TD_m5"=>"NEUTRAL","TD_m15"=>"BUY","TD_h1"=>"SELL","TD_LTS"=>"NEUTRAL","TD_HTS"=>"NEUTRAL","TD_TS"=>"SELL","EVO_5"=>"SELL","EVO_15"=>"SELL","created_at"=>"2016-11-19 22:42:44","updated_at"=>"2016-11-19 22:42:44","pair"=>["id"=>1,"pair"=>"AUDCAD","created_at"=>"2016-11-19 22:42:44","updated_at"=>"2016-11-19 22:42:44"]];
        $signal = ["id"=>1,"pair_id"=>1,"cs_signal"=>"SELL","p_m5"=>"SELL","p_m15"=>"SELL","p_m30"=>"SELL","p_h1"=>"SELL","TD_m5"=>"SELL","TD_m15"=>"SELL","TD_h1"=>"SELL","TD_LTS"=>"SELL","TD_HTS"=>"SELL","TD_TS"=>"SELL","EVO_5"=>"SELL","EVO_15"=>"SELL","created_at"=>"2016-11-19 22:42:44","updated_at"=>"2016-11-19 22:42:44","pair"=>["id"=>1,"pair"=>"AUDCAD","created_at"=>"2016-11-19 22:42:44","updated_at"=>"2016-11-19 22:42:44"]];

        broadcast(new SendForexData([$signal, $signal]));

    }

    public function calculate()
    {
        $signals = Signal::with('pair')->get()->toArray();

        broadcast(new SendForexData($signals));

    }

}
