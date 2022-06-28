<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test API V1 get profile success
     *
     * @return void
     */
    public function test_get_profile_success()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get('/api/v1/users/profile');

        $response->assertOk()
                 ->assertJson([
                     'status' => true,
                 ]);
    }

    /**
     * Test API V1 get profile failed
     *
     * @return void
     */
    public function test_get_profile_failed()
    {
        $response = $this->get('/api/v1/users/profile');

        $response->assertUnauthorized();
    }
}
