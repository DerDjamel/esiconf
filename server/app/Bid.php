<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $guarded = [];

    public function paper()
    {
        return $this->belongsto('App\Paper');
    }

    public function reviewer()
    {
        return $this->belongsto('App\Reviewer');
    }
}
