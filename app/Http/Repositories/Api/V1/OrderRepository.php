<?php

namespace App\Http\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Models\Order;
use App\Http\Resources\Api\V1\OrderResource;

class OrderRepository
{
    use ApiFilterTrait;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Search Orders
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\OrderResource
     */
    public function searchOrders($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->order->whereUserId(auth()->id());
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
        return OrderResource::collection($data);
    }
}
