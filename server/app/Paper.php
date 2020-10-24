<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reviewer;
use App\Author;


class Paper extends Model
{
    protected $guarded = [];

    protected $with = ['conference', 'authors'];

    protected $appends = ['is_chair', 'is_author', 'is_reviewer'];

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

    public function getIsChairAttribute(){
        return $this->conference->user_id == auth()->id();
    }

    public function getIsReviewerAttribute(){
        return Reviewer::where('user_id', auth()->id())->where('paper_id', $this->id)->get()->count() > 0;
    }

    public function getIsAuthorAttribute(){
        return (Author::where('user_id', auth()->id())->where('paper_id', $this->id)->get())->count() > 0;
    }

 
}
