<?php

namespace App\Http\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Models\Vehicle;
use App\Models\Order;
use App\Http\Resources\Api\V1\OrderResource;

class OrderRepository
{
    use ApiFilterTrait;

    protected $orderable = [
        'Vehicle' => Vehicle::class
    ];

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

    /**
     * Check order item vailable
     * @param array $data
     * @return array
     */
    public function checkOrderItemAvailable($data)
    {
        $status = false;
        $message = 'Item not available';

        try {
            if (isset($this->orderable[$data['orderable_type']])) {
                $item = $this->orderable[$data['orderable_type']]::find($data['orderable_id']);
                if (!$item) {
                    $message = 'Item not found';
                } else {
                    if ($item->stock - $data['quantity'] < 0) {
                        $message = 'Stock not enough';
                    } else {
                        $status = true;
                        $message = 'Item available';
                    }
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            $message = $th->getMessage();
        }

        $response = [
            'status' => $status,
            'message' => $message,
            'item' => $item ?? null,
        ];
        return $response;
    }

    /**
     * Create Order
     * @param array $data
     * @return array
     */
    public function createOrder($data)
    {
        $check = $this->checkOrderItemAvailable($data);
        $status = $check['status'];
        $message = $check['message'];
        $item = $check['item'];

        try {
            if ($status) {
                // Create Order
                $data['total_price'] = $item->price * $data['quantity'];
                $data['user_id'] = auth()->id();
                $order = $this->order->create($data);

                // Reduce item stock
                $orderable = $order->orderable;
                $orderable->stock -= $order->quantity;
                $orderable->save();
            }
        } catch (\Throwable $th) {
            //throw $th;
            $status = false;
            $message = $th->getMessage();
        }

        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $order ?? null,
        ];
        return $response;
    }
}
