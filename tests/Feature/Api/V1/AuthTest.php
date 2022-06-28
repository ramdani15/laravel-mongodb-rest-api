<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test API V1 login success
     *
     * @return void
     */
    public function test_login_success()
    {
        $password = 'password123';
        $user = User::factory(['password' => bcrypt($password)])->create();

        $response = $this->post('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        $response->assertOk()
                 ->assertJson([
                     'status' => true,
                 ]);
    }

    /**
     * Test API V1 login failed
     *
     * @return void
     */
    public function test_login_failed()
    {
        $password = 'password123';
        $user = User::factory(['password' => bcrypt($password)])->create();

        $response = $this->post('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'wrongpassword'
        ]);

        $response->assertUnauthorized();
    }

    /**
     * Test API V1 logout success
     *
     * @return void
     */
    public function test_logout_success()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post('/api/v1/auth/logout', []);

        $response->assertOk();
    }

    /**
     * Test API V1 logout failed
     *
     * @return void
     */
    public function test_logout_failed()
    {
        $response = $this->post('/api/v1/auth/logout', []);

        $response->assertUnauthorized();
    }
}
