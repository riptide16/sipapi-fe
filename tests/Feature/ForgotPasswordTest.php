<?php

namespace Tests\Feature;

use App\Services\AdminService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->mockData = [
            "data" => [],
            "success" => true,
            "message" => "Sukses"
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanAccessForgotPassword()
    {
        $response = $this->get(route('forgot_password.index'));

        $response->assertStatus(200);
    }

    public function testForgotPasswordSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('forgot_password.store'), [
            'email' => 'example@mail.com'
        ]);

        $response->assertRedirect(route('forgot_password.index'));
    }

    public function testForgotPasswordFailed()
    {
        $response = $this->json('POST', route('forgot_password.store'), [
            'email' => 'example'
        ]);

        $response->assertStatus(422);
    }
}
