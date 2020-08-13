<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    protected $with = ['user'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function conference()
    {
        return $this->belongsTo('App\Conference');
    }
}
