<?php

namespace App\Http\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Models\Vehicle;
use App\Http\Resources\Api\V1\VehicleResource;

class VehicleRepository
{
    use ApiFilterTrait;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    /**
     * Search Vehicles
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\VehicleResource
     */
    public function searchVehicles($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->vehicle;
        $filters = [
            [
                'field' => 'name',
                'value' => $request->name,
                'query' => 'like',
            ],
            [
                'field' => 'color',
                'value' => $request->color,
                'query' => 'like',
            ],
            [
                'field' => 'price',
                'value' => $request->price,
                'query' => 'like',
            ],
        ];
        $data = $this->filterFields($data, $filters);
        $data = $this->setOrder($data, ['created_at', '-1']);
        $data = $data->paginate($limit);
        return VehicleResource::collection($data);
    }
}
