<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource;

class UserController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *  path="/api/v1/users/profile",
     *  summary="Get current's user profile",
     *  description="Endpoint to get logged in user",
     *  tags={"Users"},
     *  security={
     *      {"token": {}}
     *  },
     *  @OA\Response(
     *      response=200,
     *      description="OK",
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *  )
     * )
     */
    public function profile()
    {
        $user = auth()->user();
        if (!$user) {
            return $this->responseJson('error', 'Unauthorized.', '', 401);
        }
        return $this->responseJson('success', 'Get profile successfully', new UserResource($user));
    }
}
