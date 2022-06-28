<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\OrderStoreRequest;
use App\Http\Resources\Api\V1\OrderDetailResource;
use App\Models\Order;
use Facades\App\Http\Repositories\Api\V1\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *  path="/api/v1/orders",
     *  summary="Get list orders",
     *  description="Endpoint to get list orders",
     *  tags={"Orders"},
     *  security={
     *      {"token": {}}
     *  },
     *  @OA\Parameter(
     *      name="limit",
     *      in="query",
     *      description="Limit (Default 10)"
     *  ),
     *  @OA\Parameter(
     *      name="page",
     *      in="query",
     *      description="Num Of Page"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Ok",
     *      @OA\JsonContent(
     *          @OA\Property(property="data", type="object", example={}),
     *              @OA\Property(property="pagination", type="object", example={}),
     *      )
     *  ),
     *  @OA\Response(
     *      response=500,
     *      description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to get list orders."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *      )
     *  ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $data = OrderRepository::searchOrders($request);
            return $this->responseJson('pagination', 'Get list orders successfully.', $data, 200, []);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to get list orders.', $th, 500);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/v1/orders",
     *  summary="Create order",
     *  description="Endpoint to handle create order",
     *  tags={"Orders"},
     *  security={
     *      {"token": {}}
     *  },
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          required={"quantity"},
     *          @OA\Property(property="quantity", type="numeric", example=1),
     *          @OA\Property(property="orderable_id", type="string", example="62bacc8b009f5302930e15ab"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="OK",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="Bad Request",
     *  ),
     * )
     */
    public function store(OrderStoreRequest $request)
    {
        $data = $request->validated();
        $data['orderable_type'] = 'Vehicle';
        $response = OrderRepository::createOrder($data);
        return $this->responseJson(
            $response['status'] ? 'success' : 'error',
            $response['message'],
            $response['status'] ? $response['data'] : null,
            $response['status'] ? 201 : 400,
        );
    }

    /**
     * @OA\Get(
     *       path="/api/v1/orders/{id}",
     *       summary="Get detail order",
     *       description="Endpoint to get detail order",
     *       tags={"Orders"},
     *       security={
     *           {"token": {}}
     *       },
     *       @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Order ID"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *      ),
     * )
     */
    public function show($id)
    {
        $order = Order::firstWhere([
            '_id' => $id,
            'user_id' => auth()->id()
        ]);
        if (!$order) {
            return $this->responseJson('error', 'Not found.', '', 404);
        }
        return $this->responseJson('success', 'Get detail order successfully', new OrderDetailResource($order));
    }
}
