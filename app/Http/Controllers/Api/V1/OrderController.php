<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use App\Http\Controllers\Controller;
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
