<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use App\Models\Order;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * Test API V1 get list orders success
     *
     * @return void
     */
    public function test_get_list_orders_success()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->get('/api/v1/orders');

        $response->assertOk()
                 ->assertSeeText('data')
                 ->assertSeeText('pagination');
    }

    /**
     * Test API V1 get list orders failed
     *
     * @return void
     */
    public function test_get_list_orders_failed()
    {
        $response = $this->get('/api/v1/orders');

        $response->assertUnauthorized();
    }

    /**
     * Test API V1 get detail orders success
     *
     * @return void
     */
    public function test_get_detail_orders_success()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $order = Order::factory(['user_id' => $user->_id])->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->get('/api/v1/orders/'.$order->_id);

        $response->assertOk()
                 ->assertJson([
                     'status' => true
                 ]);
    }

    /**
     * Test API V1 get list orders failed
     *
     * @return void
     */
    public function test_get_detail_orders_failed()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $order = Order::factory(['user_id' => $user->_id])->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->get('/api/v1/orders/xx'.$order->_id);

        $response->assertNotFound();
    }

    /**
     * Test API V1 create orders success
     *
     * @return void
     */
    public function test_create_orders_success()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $vehicle = Vehicle::factory(['quantity' => 10])->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->post('/api/v1/orders', [
            'quantity' => 2,
            'orderable_id' => $vehicle->_id
        ]);

        $response->assertCreated();

        $response = json_decode($response->getContent());
        $orderId = $response->data->_id;
        $order = Order::find($orderId);
        $this->assertTrue($order->orderable->is($vehicle));
    }

    /**
     * Test API V1 create orders success
     *
     * @return void
     */
    public function test_create_orders_failed()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $vehicle = Vehicle::factory(['quantity' => 10])->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->post('/api/v1/orders', [
            'quantity' => 5,
            'orderable_id' => 'xx'.$vehicle->_id
        ]);

        $response->assertStatus(400);
    }
}
