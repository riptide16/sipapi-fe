<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->mockData = [
            "data" => [],
            "success" => true,
            "message" => "string"
        ];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanAccessResetPasswordPage()
    {
        $response = $this->get(route('forgot_password.edit') . "?token=121213&email=test@mail.com");

        $response->assertStatus(200);
    }

    public function testCannotAccessResetPasswordPage()
    {
        $response = $this->get(route('forgot_password.edit'));

        $response->assertStatus(500);
    }

    // public function testCanSuccessResetPassword()
    // {
    //     $this->mock(AdminService::class, function ($mock) {
    //         $mock->shouldReceive('createNew')
    //             ->once()
    //             ->andReturn($this->mockData);
    //     });

    //     $response = $this->post(
    //         route('forgot_password.update', [
    //             'token' => 'df4237e8071c9b2d68edbe973eac542fbab64842ce734aaa4ff3c69015134102'
    //         ]),
    //         [
    //             'token' => 'df4237e8071c9b2d68edbe973eac542fbab64842ce734aaa4ff3c69015134102',
    //             'email' => 'arcus@dispostable.com',
    //             'password' => '123456789',
    //             'password_confirmation' => '123456789'
    //         ]
    //     );

    //     $response->assertRedirect(route('forgot_password.edit'));
    // }

    public function testCannotSuccessResetPassword()
    {
        $response = $this->json(
            'POST',
            route('forgot_password.update', [
                'token' => 'df4237e8071c9b2d68edbe973eac542fbab64842ce734aaa4ff3c69015134102'
            ]),
            [
                'email' => 'arcus@dispostable.com',
                'password' => '123456789',
                'password_confirmation' => '1234567'
            ]
        );

        $response->assertStatus(422);
    }
}
