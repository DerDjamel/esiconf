<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];

    protected $appends = ['is_chair', 'is_reviewer'];

    protected $with = ['paper', 'reviewer'];
    
    public function reviewer()
    {
        return $this->belongsTo('App\Reviewer');
    }

    public function paper()
    {
        return $this->belongsTo('App\Paper');
    }

    public function getIsChairAttribute(){
        return $this->paper->conference->user_id == auth()->id();
    }

    public function getIsReviewerAttribute(){
        return $this->reviewer->user_id == auth()->id();
    }
}
