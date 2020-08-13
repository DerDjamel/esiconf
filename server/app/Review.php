<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];

    protected $with = ['paper', 'reviewer'];
    
    public function reviewer()
    {
        return $this->belongsTo('App\Reviewer');
    }

    public function paper()
    {
        return $this->belongsTo('App\Paper');
    }
}
