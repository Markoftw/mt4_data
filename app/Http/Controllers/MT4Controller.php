<?php

namespace App\Http\Controllers;

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

    public function api_Json()
    {
        $data = Arrow::with('pair')->get()->toJson();

        return response($data);
    }

}
