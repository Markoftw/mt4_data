<?php

namespace App\Http\Controllers;

use App\Events\SendHistorySignalsData;
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

    public function store(Request $request)
    {
        $history = '';
        switch ($request->input('history_period')) {
            case 'm5':
                $history = History::where('id', $request->input('history_id'))->update(['m5' => $request->input('history_value')]);
                break;
            case 'm15':
                $history = History::where('id', $request->input('history_id'))->update(['m15' => $request->input('history_value')]);
                break;
            case 'h1':
                $history = History::where('id', $request->input('history_id'))->update(['h1' => $request->input('history_value')]);
                break;
            case 'rating':
                $history = History::where('id', $request->input('history_id'))->update(['rating' => $request->input('history_value')]);
                break;
        }

        if($history) {
            $new_history = $this->getData();
            broadcast(new SendHistorySignalsData($new_history));
        }
    }

}
