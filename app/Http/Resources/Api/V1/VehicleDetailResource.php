<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $details = [
            'Car' => CarResource::class,
            'Motorcycle' => MotorcycleResource::class,
        ];
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'price' => $this->price,
            'stock' => $this->stock,
            'attachable_type' => $this->attachable_type,
            'attachable_id' => $this->attachable_id,
            'detail' => isset($details[$this->attachable_type]) ? new $details[$this->attachable_type]($this->attachable) : null,
        ];
    }
}
