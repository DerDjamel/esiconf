<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $guarded = [];

    protected $with = ['conference', 'authors'];

    public function authors(){
        return $this->hasMany('App\Author');
    }

    public function reviewers(){
        return $this->hasMany('App\Reviewer');
    }

    public function conference()
    {
        return $this->belongsTo('App\Conference');
    }

 
}
