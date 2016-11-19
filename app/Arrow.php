<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arrow extends Model
{
    protected $table = 'arrows';

    protected $fillable = ['m5_color', 'm15_color', 'h1_color', 'lts_color', 'hts_color', 'ts_color', 'ts_direction'];

    protected $hidden = [];
}
