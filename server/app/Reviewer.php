<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    protected $with = ['user', 'paper'];
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo('App\User');
    }



    public function conference()
    {
        return $this->belongsTo('App\Conference');
    }

    public function paper()
    {
        return $this->belongsTo('App\Paper');
    }
}
