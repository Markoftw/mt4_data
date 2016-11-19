<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CStrength extends Model
{
    protected $table = 'cstrengths';

    protected $fillable = ['usd_now', 'usd_then', 'eur_now', 'eur_then', 'gbp_now', 'gbp_then', 'chf_now', 'chf_then', 'jpy_now', 'jpy_then', 'aud_now', 'aud_then', 'cad_now', 'cad_then', 'nzd_now', 'nzd_then', 'mkt'];

    protected $hidden = [];
}
