<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
