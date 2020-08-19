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

    public function papers()
    {
        return $this->hasMany('App\Paper');
    }

    public function reviewers()
    {
        return $this->hasMany('App\Reviewer');
    }

    public function reviews()
    {
        return $this->hasManyThrough('App\Review', 'App\Paper', 'conference_id', 'paper_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
