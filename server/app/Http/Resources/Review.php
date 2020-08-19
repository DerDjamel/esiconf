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
        return [
            'id' => $this->id,
            'title' => $this->paper->title,
            'opinion' => $this->opinion,
            'comment' => $this->comment,
            'reviewer' => $this->reviewer->user->name,
        ];
    }
}
