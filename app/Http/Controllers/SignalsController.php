<?php

namespace App\Http\Controllers;

use App\History;
use Illuminate\Http\Request;

class SignalsController extends Controller
{

    public function index()
    {
        return view('forex_history');
    }

    public function getData()
    {
        $history = History::with('pair')->orderBy('id', 'DESC')->get()->toArray();
        return $history;
    }

    public function store()
    {

    }

}
