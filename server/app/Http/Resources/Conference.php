<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use Carbon\Carbon;
class Conference extends JsonResource
{
    public static $wrap = 'conference';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'country'       => $this->country,
            'city'          => $this->city,
            'start'         => Carbon::parse($this->start)->toFormattedDateString(),
            'end'           => Carbon::parse($this->end)->toFormattedDateString(),
            'webpage'       => $this->webpage,
            'description'   => $this->description,
            'chair'         => new UserResource($this->user)
        ];
    }
}
