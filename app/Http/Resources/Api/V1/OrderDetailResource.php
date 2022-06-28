<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'Vehicle' => VehicleDetailResource::class,
        ];
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'user_id' => $this->user_id,
            'orderable_type' => $this->orderable_type,
            'orderable_id' => $this->orderable_id,
            'detail' => isset($details[$this->orderable_type]) ? new $details[$this->orderable_type]($this->orderable) : null,
        ];
    }
}
