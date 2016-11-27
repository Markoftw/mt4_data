<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {

    }

    public function calculate_one()
    {
        $signal = ["id" => 1, "pair_id" => 1, "cs_signal" => "NO", "p_m5" => "BUY", "p_m15" => "SELL", "p_m30" => "SELL", "p_h1" => "SELL", "TD_m5" => "NEUTRAL", "TD_m15" => "BUY", "TD_h1" => "SELL", "TD_LTS" => "NEUTRAL", "TD_HTS" => "NEUTRAL", "TD_TS" => "SELL", "EVO_5" => "SELL", "EVO_15" => "SELL", "updated_at" => "2016-11-19 22:42:44", "pair" => ["id" => 1, "pair" => "AUDCAD", "created_at" => "2016-11-19 22:42:44", "updated_at" => "2016-11-19 22:42:44"]];
        $signal2 = ["id" => 2, "pair_id" => 2, "cs_signal" => "SELL", "p_m5" => "SELL", "p_m15" => "SELL", "p_m30" => "SELL", "p_h1" => "SELL", "TD_m5" => "SELL", "TD_m15" => "SELL", "TD_h1" => "SELL", "TD_LTS" => "SELL", "TD_HTS" => "SELL", "TD_TS" => "SELL", "EVO_5" => "SELL", "EVO_15" => "SELL", "updated_at" => "2016-11-19 22:42:44", "pair" => ["id" => 1, "pair" => "AUDCHF", "created_at" => "2016-11-19 22:42:44", "updated_at" => "2016-11-19 22:42:44"]];

        broadcast(new SendForexData([$signal, $signal2]));
    }
}
