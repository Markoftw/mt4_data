<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signal extends Model
{
    protected $table = 'signals';

    protected $fillable = ['cs_signal', 'p_m5', 'p_m15', 'p_m30', 'p_h1', 'TD_m5', 'TD_m15', 'TD_h1', 'TD_LTS', 'TD_HTS', 'TD_TS', 'EVO_5', 'EVO_15'];

    protected $hidden = ['created_at', 'updated_at'];

    public function pair()
    {
        return $this->belongsTo(Pair::class, 'pair_id');
    }

    public function getDates()
    {
        return array();
    }

}
