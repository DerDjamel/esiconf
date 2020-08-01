<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $guarded = [];

    public function authors(){
        return $this->hasMany('App\Author');
    }

    public function conference()
    {
        return $this->belongsTo('App\Conference');
    }

 
}
