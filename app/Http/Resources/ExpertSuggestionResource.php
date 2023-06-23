<?php

namespace App\Http\Resources;

use App\Enums\CompatriotTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpertSuggestionResource extends JsonResource
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
            'user_id' => $this->user_id,
            'suggestions' => $this->suggestions,
            'additional_information' => $this->additional_information,
            'images' => json_decode($this->images),
            'type' => $this->type
        ];
    }
}
