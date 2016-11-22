<?php

namespace App\Http\Controllers;

use App\Events\SendForexData;
use DB;
use Illuminate\Http\Request;
use App\Arrow;
use App\CStrength;
use App\Data;
use App\History;
use App\Pair;
use App\Price;
use App\Signal;
use Response;

class MT4Controller extends Controller
{
    private $cstrength_all = [];
    private $prices_all = [];
    private $arrows_all = [];
    private $pairs = ["AUDCAD", "AUDCHF", "AUDJPY", "AUDNZD", "AUDUSD", "CADCHF", "CADJPY", "CHFJPY", "EURAUD", "EURCAD",
                      "EURCHF", "EURGBP", "EURJPY", "EURNZD", "EURUSD", "GBPAUD", "GBPCAD", "GBPCHF", "GBPJPY", "GBPNZD",
                      "GBPUSD", "NZDJPY", "NZDUSD", "USDCAD", "USDCHF", "USDJPY"];
    private $razlika = 0;
    private $old_signals = [];

    public function index()
    {
        return view('forex_table');
    }

    public function getData()
    {
        $date = Signal::first()->updated_at;
        $signals = Signal::with('pair')->get()->toArray();
        $signals[0]['updated_at'] = $date;
        return $signals;
    }

    public function calculate_one()
    {
        $signal = ["id"=>1,"pair_id"=>1,"cs_signal"=>"NO","p_m5"=>"BUY","p_m15"=>"SELL","p_m30"=>"SELL","p_h1"=>"SELL","TD_m5"=>"NEUTRAL","TD_m15"=>"BUY","TD_h1"=>"SELL","TD_LTS"=>"NEUTRAL","TD_HTS"=>"NEUTRAL","TD_TS"=>"SELL","EVO_5"=>"SELL","EVO_15"=>"SELL","updated_at"=>"2016-11-19 22:42:44","pair"=>["id"=>1,"pair"=>"AUDCAD","created_at"=>"2016-11-19 22:42:44","updated_at"=>"2016-11-19 22:42:44"]];
        $signal2 = ["id"=>2,"pair_id"=>2,"cs_signal"=>"SELL","p_m5"=>"SELL","p_m15"=>"SELL","p_m30"=>"SELL","p_h1"=>"SELL","TD_m5"=>"SELL","TD_m15"=>"SELL","TD_h1"=>"SELL","TD_LTS"=>"SELL","TD_HTS"=>"SELL","TD_TS"=>"SELL","EVO_5"=>"SELL","EVO_15"=>"SELL","updated_at"=>"2016-11-19 22:42:44","pair"=>["id"=>1,"pair"=>"AUDCHF","created_at"=>"2016-11-19 22:42:44","updated_at"=>"2016-11-19 22:42:44"]];

        broadcast(new SendForexData([$signal, $signal2]));
    }

    public function calculate()
    {
        $this->old_signals = Signal::with('pair')->get()->toArray();
        $this->prices_all = Price::all();
        $this->arrows_all = Arrow::all();
        $this->cstrength_all = CStrength::all();
        $this->razlika = Data::where('data_type', 'razlika')->first()->data;

        $update_counter = 1;
        for($i = 0; $i < 26; $i++) {
            $bid_price = $this->prices_all[$i]->bid_price;
            if($bid_price > $this->prices_all[$i]->period_m5) {
                Signal::where('id', $update_counter)->update(['p_m5' => 'BUY']);
            } else {
                Signal::where('id', $update_counter)->update(['p_m5' => 'SELL']);
            }
            if($bid_price > $this->prices_all[$i]->period_m15) {
                Signal::where('id', $update_counter)->update(['p_m15' => 'BUY']);
            } else {
                Signal::where('id', $update_counter)->update(['p_m15' => 'SELL']);
            }
            if($bid_price > $this->prices_all[$i]->period_m30) {
                Signal::where('id', $update_counter)->update(['p_m30' => 'BUY']);
            } else {
                Signal::where('id', $update_counter)->update(['p_m30' => 'SELL']);
            }
            if($bid_price > $this->prices_all[$i]->period_h1) {
                Signal::where('id', $update_counter)->update(['p_h1' => 'BUY']);
            } else {
                Signal::where('id', $update_counter)->update(['p_h1' => 'SELL']);
            }
            // Arrows - 255 = RED, 32768 = GREEN, 65535 = ORANGE
            if($this->arrows_all[$i]->m5_color == '32768') {
                Signal::where('id', $update_counter)->update(['TD_m5' => 'BUY']);
            } else if($this->arrows_all[$i]->m5_color == '255') {
                Signal::where('id', $update_counter)->update(['TD_m5' => 'SELL']);
            } else {
                Signal::where('id', $update_counter)->update(['TD_m5' => 'NO']);
            }
            if($this->arrows_all[$i]->m15_color == '32768') {
                Signal::where('id', $update_counter)->update(['TD_m15' => 'BUY']);
            } else if($this->arrows_all[$i]->m15_color == '255') {
                Signal::where('id', $update_counter)->update(['TD_m15' => 'SELL']);
            } else {
                Signal::where('id', $update_counter)->update(['TD_m15' => 'NO']);
            }
            if($this->arrows_all[$i]->h1_color == '32768') {
                Signal::where('id', $update_counter)->update(['TD_h1' => 'BUY']);
            } else if($this->arrows_all[$i]->h1_color == '255') {
                Signal::where('id', $update_counter)->update(['TD_h1' => 'SELL']);
            } else {
                Signal::where('id', $update_counter)->update(['TD_h1' => 'NO']);
            }
            if($this->arrows_all[$i]->lts_color == '32768') {
                Signal::where('id', $update_counter)->update(['TD_LTS' => 'BUY']);
            } else if($this->arrows_all[$i]->lts_color == '255') {
                Signal::where('id', $update_counter)->update(['TD_LTS' => 'SELL']);
            } else {
                Signal::where('id', $update_counter)->update(['TD_LTS' => 'NO']);
            }
            if($this->arrows_all[$i]->hts_color == '32768') {
                Signal::where('id', $update_counter)->update(['TD_HTS' => 'BUY']);
            } else if($this->arrows_all[$i]->hts_color == '255') {
                Signal::where('id', $update_counter)->update(['TD_HTS' => 'SELL']);
            } else {
                Signal::where('id', $update_counter)->update(['TD_HTS' => 'NO']);
            }
            if($this->arrows_all[$i]->ts_color == '32768') {
                Signal::where('id', $update_counter)->update(['TD_TS' => 'BUY']);
            } else if($this->arrows_all[$i]->ts_color == '255') {
                Signal::where('id', $update_counter)->update(['TD_TS' => 'SELL']);
            } else {
                Signal::where('id', $update_counter)->update(['TD_TS' => 'NO']);
            }
            // EVO
            if($this->prices_all[$i]->m5_up != '2147483647') {
                Signal::where('id', $update_counter)->update(['EVO_5' => 'BUY']);
            } else {
                Signal::where('id', $update_counter)->update(['EVO_5' => 'SELL']);
            }
            if($this->prices_all[$i]->m15_up != '2147483647') {
                Signal::where('id', $update_counter)->update(['EVO_15' => 'BUY']);
            } else {
                Signal::where('id', $update_counter)->update(['EVO_15' => 'SELL']);
            }
            $update_counter++;
        }

        for($j = 0; $j < 26; $j++){
            $this->cstrength($this->pairs[$j], $j);
        }

        $new = Signal::with('pair')->get()->toArray();
        $different = false;
        for($i = 0; $i < 26; $i++) {
            if($new[$i] === $this->old_signals[$i]) {

            } else {
                $different = true;
            }
        }

        if($different) {
            $new[0]['updated_at'] = date("Y-m-d H:i:s");
            broadcast(new SendForexData($new));
        }
    }

    public function tests()
    {
        $this->old_signals = Signal::with('pair')->get()->toArray();
        Signal::where('id', 1)->update(['cs_signal' => 'Value']);
        $new = Signal::with('pair')->get()->toArray();
        $different = false;
        for($i = 0; $i < 26; $i++) {
            if($new[$i] === $this->old_signals[$i]) {

            } else {
                $different = true;
            }
        }
        if($different) {
            echo 'Works';
        }
    }

    public function storeHistory(Request $request)
    {
        $pair = Pair::with('prices')->where('pair', $request->input('pair_name'))->get();
        $pair_price = $pair[0]->prices[0]->bid_price;
        $history_data = [
            'order_type' => "{$request->input('order_type')}",
            'bid_price' => $pair_price,
            'rating' => 'rate'
        ];
        $p = Pair::find($request->input('pair_id'));
        $history = $p->history()->create($history_data);
        if($history) {
            return Response::json([
                'errors' => false,
                'data' => 'success',
            ]);
        }
        return Response::json([
            'message' => '400 error',
            'errors' => [
                'message' => ['error'],
            ],
            'status_code' => 400,
        ], 400);
    }

    public function storeSetting(Request $request)
    {                                                  // razlika                                         // 1.2
        $data = Data::where('data_type', $request->only('data_type'))->update(['data' => $request->only('data_value')]);
        if($data) {
            return Response::json([
                'errors' => false,
                'data' => 'success',
            ]);
        }
        return Response::json([
            'message' => '400 error',
            'errors' => [
                'message' => ['error'],
            ],
            'status_code' => 400,
        ], 400);
    }

    private function cstrength($item, $id)
    {
        $par_1 = substr($item,0,3);
        $par_2 = substr($item,3,6);

        $difference = $this->razlika;

        $val_1 = $this->getValues($par_1);
        $val_2 = $this->getValues($par_2);

        // val_1[0] == GBP_NOW, val_1[1] == GBP_THEN
        // val_2[0] == JPY_NOW, val_2[1] == JPY_THEN

        $difference_now = abs($val_1[0] - $val_2[0]);
        $difference_then = abs($val_1[1] - $val_2[1]);

        if($difference_now/$difference > $difference_then && $val_1[0] >= $val_1[1] && $val_2[0] <= $val_2[1] && $val_1[0] > $val_2[0]
            || $difference_now*$difference < $difference_then && $val_1[0] >= $val_1[1] && $val_2[0] <= $val_2[1] && $val_2[0] > $val_1[0]){
            Signal::where('id', ++$id)->update(['cs_signal' => 'BUY']);
        } else if ($difference_now/$difference > $difference_then && $val_2[0] >= $val_2[1] && $val_1[0] <= $val_1[1] && $val_2[0] > $val_1[0]
            || $difference_now*$difference < $difference_then && $val_2[0] >= $val_2[1] && $val_1[0] <= $val_1[1] && $val_1[0] > $val_2[0]){
            Signal::where('id', ++$id)->update(['cs_signal' => 'SELL']);
        } else{
            Signal::where('id', ++$id)->update(['cs_signal' => 'NO']);
        }
    }

    private function getValues($value) {
        switch ($value) {
            case "GBP":
                $arr = [$this->cstrength_all[0]->gbp_now, $this->cstrength_all[0]->gbp_then];
                return $arr;
                break;
            case "JPY":
                $arr = [$this->cstrength_all[0]->jpy_now, $this->cstrength_all[0]->jpy_then];
                return $arr;
                break;
            case "EUR":
                $arr = [$this->cstrength_all[0]->eur_now, $this->cstrength_all[0]->eur_then];
                return $arr;
                break;
            case "USD":
                $arr = [$this->cstrength_all[0]->usd_now, $this->cstrength_all[0]->usd_then];
                return $arr;
                break;
            case "NZD":
                $arr = [$this->cstrength_all[0]->nzd_now, $this->cstrength_all[0]->nzd_then];
                return $arr;
                break;
            case "CHF":
                $arr = [$this->cstrength_all[0]->chf_now, $this->cstrength_all[0]->chf_then];
                return $arr;
                break;
            case "AUD":
                $arr = [$this->cstrength_all[0]->aud_now, $this->cstrength_all[0]->aud_then];
                return $arr;
                break;
            case "CAD":
                $arr = [$this->cstrength_all[0]->cad_now, $this->cstrength_all[0]->cad_then];
                return $arr;
                break;
            default:
                return false;
                break;
        }
    }
}
