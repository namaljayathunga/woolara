<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserApiRegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_registers_a_user_via_api()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
        ];

        $response = $this->json('POST', '/api/register', $userData);

        $response->assertStatus(201);
        $response->assertJsonStructure(['status', 'token', 'message']);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);
    }

    /** @test */
    public function it_requires_name_email_and_password_for_registration()
    {
        $response = $this->json('POST', '/api/register', []);
        $response->assertStatus(401);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }
}
