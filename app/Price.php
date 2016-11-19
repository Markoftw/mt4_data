<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'prices';

    protected $fillable = ['para', 'bid_price', 'period_m5', 'period_m15', 'period_m30', 'period_h1', 'm5_up', 'm15_up'];

    protected $hidden = [];

    public function pair()
    {
        return $this->belongsTo(Pair::class, 'pair_id');
    }

}
