<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $guarded = [];

    public function authors(){
        return $this->hasMany('App\Author');
    }
}
