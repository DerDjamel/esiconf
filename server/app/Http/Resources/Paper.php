<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Conference as ConferenceResource;
use App\Reviewer;
use App\Author;
use Illuminate\Support\Arr;
class Paper extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $authors = '';
        foreach($this->authors as $author){
            $authors = $authors . $author->user->name . ', ';
        }

        $reviewers = '';
        foreach($this->reviewers as $reviewer){
            $reviewers = $reviewers . $reviewer->user->name . ', ';
        }
        $is_reviewer = Reviewer::where('user_id', auth()->id())->where('paper_id', $this->id)->get()->count() > 0;
        $is_author = (Author::where('user_id', auth()->id())->where('paper_id', $this->id)->get())->count() > 0;

        $is_chair = $this->conference->user_id == auth()->id();
        
        return [    
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'conference' => new ConferenceResource($this->conference),
            'authors' => substr($authors , 0, -2),
            'reviewers' => !$reviewers ? 'None': $reviewers,
            'is_reviewer' => $is_reviewer,
            'is_author' => $is_author,
            'is_chair' => $is_chair
        ];
    }
}
