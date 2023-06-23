<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEmploymentInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'company' => $this->company,
            'position' => $this->position,
            'location_name' => $this->location->name,
            'location_id' => $this->location_id,
            'city' => $this->city,
            'experience' => $this->timeDecode($this->start_date, $this->finish_date),
            'start_date' => $this->start_date,
            'status' => $this->status,
            'finish_date' => $this->finish_date,
            'specialization' => $this->specialization,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

    }

    public function timeDecode($start, $finish): float
    {

        return $finish
            ? floor(abs(strtotime($start) - strtotime($finish)) / (365*60*60*24))
            : floor(abs(strtotime($start) - strtotime(date('Y-m-d'))) / (365*60*60*24));
    }
}
