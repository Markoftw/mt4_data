<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $fillable = ['order_type', 'bid_price', 'rating'];

    protected $hidden = [];

    public function pair()
    {
        return $this->belongsTo(Pair::class, 'pair_id');
    }
}
