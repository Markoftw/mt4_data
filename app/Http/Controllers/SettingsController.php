<?php

namespace App\Http\Controllers;

use App\Data;
use App\Events\ForceRefreshPage;
use App\Events\SendSettingData;
use App\User;
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

    public function storeNotifications(Request $request)
    {
        $arr = [];
        $users = User::all();
        foreach ($users as $user) {
            array_push($arr, $user->id);
        }
        $arr_curr = [];
        $items = explode(',', $request->input('checkedUsers'));
        foreach($items as $check) {
            User::where('id', $check)->update(['active_sms' => true]);
            array_push($arr_curr, $check);
        }
        $unchecked = array_diff($arr, $arr_curr);
        foreach ($unchecked as $item) {
            User::where('id', $item)->update(['active_sms' => false]);
        }

        broadcast(new SendSettingData(['smsnotify' => $arr_curr]));
    }
}
