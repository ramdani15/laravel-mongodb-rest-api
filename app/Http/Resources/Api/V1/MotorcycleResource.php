<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class MotorcycleResource extends JsonResource
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
            'machine' => $this->machine,
            'suspension_type' => $this->suspension_type,
            'transmission_type' => $this->transmission_type,
        ];
    }
}
