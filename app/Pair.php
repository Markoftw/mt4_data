<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{

    protected $table = 'pairs';

    protected $fillable = ['pair'];

    protected $hidden = [];

    public function arrows()
    {
        return $this->hasMany(Arrow::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function signals()
    {
        return $this->hasMany(Signal::class);
    }
}
