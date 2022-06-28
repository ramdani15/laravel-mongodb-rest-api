<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\VehicleDetailResource;
use App\Models\Vehicle;
use Facades\App\Http\Repositories\Api\V1\VehicleRepository;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *  path="/api/v1/vehicles",
     *  summary="Get list vehicles",
     *  description="Endpoint to get list vehicles",
     *  tags={"Vehicles"},
     *  security={
     *      {"token": {}}
     *  },
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      description="Name"
     *  ),
     *  @OA\Parameter(
     *      name="color",
     *      in="query",
     *      description="Color"
     *  ),
     *  @OA\Parameter(
     *      name="price",
     *      in="query",
     *      description="Price"
     *  ),
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
     *              @OA\Property(property="message", type="string", example="Failed to get list vehicles."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *      )
     *  ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $data = VehicleRepository::searchVehicles($request);
            return $this->responseJson('pagination', 'Get list vehicles successfully.', $data, 200, []);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to get list vehicles.', $th, 500);
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/vehicles/{id}",
     *       summary="Get detail vehicle",
     *       description="Endpoint to get detail vehicle",
     *       tags={"Vehicles"},
     *       security={
     *           {"token": {}}
     *       },
     *       @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Vehicle ID"
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
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return $this->responseJson('error', 'Not found.', '', 404);   
        }
        return $this->responseJson('success', 'Get detail vehicle successfully', new VehicleDetailResource($vehicle));
    }
}
