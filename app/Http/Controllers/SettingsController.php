<?php

namespace App\Http\Controllers;

use App\Data;
use App\Events\ForceRefreshPage;
use App\Events\SendSettingData;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function send_refresh($reason = 'Web App Updates')
    {
        broadcast(new ForceRefreshPage(['force' => true, 'reason' => $reason]));
    }

    public function storeSetting(Request $request)
    {
        $data = Data::where('data_type', $request->input('data_type'))->update(['data' => $request->input('data_value')]);
        if ($data) {
            broadcast(new SendSettingData(['razlika' => $request->input('data_value')]));
        }
    }
}
