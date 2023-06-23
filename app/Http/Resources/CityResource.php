<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sightseeingPlaces' => $this->sightseeingPlaces,
            'cityGalleries' => $this->cityGalleries,
            'cityVideos' => $this->cityVideos,
            '3DCityPhoto' => $this->city3Ds,
            'cityContentInfo' => $this->cityContentInfos
        ];
    }
}
