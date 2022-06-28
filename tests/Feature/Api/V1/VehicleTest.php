<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    /**
     * Test API V1 get list vehicles success
     *
     * @return void
     */
    public function test_get_list_vehicles_success()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->get('/api/v1/vehicles');

        $response->assertOk()
                 ->assertSeeText('data')
                 ->assertSeeText('pagination');
    }

    /**
     * Test API V1 get list vehicles failed
     *
     * @return void
     */
    public function test_get_list_vehicles_failed()
    {
        $response = $this->get('/api/v1/vehicles');

        $response->assertUnauthorized();
    }

    /**
     * Test API V1 get detail vehicles success
     *
     * @return void
     */
    public function test_get_detail_vehicles_success()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $vehicle = Vehicle::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->get('/api/v1/vehicles/'.$vehicle->_id);

        $response->assertOk()
                 ->assertJson([
                     'status' => true
                 ]);
    }

    /**
     * Test API V1 get list vehicles failed
     *
     * @return void
     */
    public function test_get_detail_vehicles_failed()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $vehicle = Vehicle::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->get('/api/v1/vehicles/xx'.$vehicle->_id);

        $response->assertNotFound();
    }
}
