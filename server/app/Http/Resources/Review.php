<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Review extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $is_owner = $this->reviewer->user_id == auth()->id();
        $is_chair = $this->paper->conference->user_id == auth()->id();
        return [
            'id' => $this->id,
            'title' => $this->paper->title,
            'opinion' => $this->opinion,
            'comment' => $this->comment,
            'reviewer' => $this->reviewer->user->name,
            'is_chair' => $is_chair,
            'is_owner' => $is_owner
        ];
    }
}
