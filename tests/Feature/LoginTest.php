<?php

namespace Tests\Feature;

use App\Services\AdminService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->mockData = [
            "data" => [
                "token_type" => "string",
                "expires_in" => 1234,
                "access_token" => "string"
            ],
            "success" => true,
            "message" => "Sukses"
        ];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanAccessLogin()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200)
            ->assertSee('Sign in to our platform');
    }

    public function testLoginSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('login.store'), $this->usertest);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function testLoginFailedEmail()
    {
        $response = $this->json('POST', route('login.store'), [
            'username' => '',
            'password' => '12345678'
        ]);

        $response->assertStatus(422)
            ->assertSee('The username field is required.');
    }

    public function testLoginFailedLengthPassword()
    {
        $response = $this->json('POST', route('login.store'), [
            'username' => 'test@mailinator.com',
            'password' => '1234567'
        ]);

        $response->assertStatus(422)
            ->assertSee('The password must be at least 8 characters.');
    }
}
