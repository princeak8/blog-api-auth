<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function testLogin()
    {
        //$user = User::factory()->createOne();  
        $response = $this->post(
            '/api/login',
            [
            'email' => 'daniel@gmail.com',
            'password' => 'daniel123',
            ]
        );  $response->assertStatus(200);
        // $response->assertJsonStructure([
        //     'success',
        //     'data' => [
        //     'token',
        //     'token_type',
        //     ]
        // ]);
        \JWTAuth::setToken($response->json('data.token'))->checkOrFail();
    }
}
