<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $fillable = ['para', 'order_type', 'bid_price', 'rating'];

    protected $hidden = [];
}
