<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'price';

    protected $fillable = ['para', 'bid_price', 'period_m5', 'period_m15', 'period_m30', 'period_h1', 'm5_up', 'm15_up'];

    protected $hidden = [];
}
