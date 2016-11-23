<?php

namespace App\Http\Controllers;

use App\Events\ForceRefreshPage;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function send_refresh($reason = 'Web App Updates')
    {
        broadcast(new ForceRefreshPage(['force' => true, 'reason' => $reason]));
    }
}
