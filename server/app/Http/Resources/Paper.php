<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Conference as ConferenceResource;

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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'conference' => new ConferenceResource($this->conference),
            'authors' => substr($authors , 0, -2),
            'reviewers' => !$reviewers ? 'None': $reviewers
        ];
    }
}
