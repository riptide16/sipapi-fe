<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withSession(['token' => $this->session]);

        $this->mockData = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                    "username" => "string",
                    "email" => "string",
                    "status" => "active",
                    "status_text" => "Aktif",
                    "role" => [
                        "id" => "string",
                        "name" => "string",
                        "display_name" => "string",
                    ]
                ]
            ]
        ];

        $this->mockRole = [
            "data" => [
                [
                    "id" => "string",
                    "name" => "string",
                    "display_name" => "string",
                ]
            ]
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanAccessIndexUsers()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });

        $this->get(route('admin.user.index'))
            ->assertStatus(200)
            ->assertSee('Data User');
    }

    public function testCanAccessShowUsers()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.user.show', ['id' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('View Data User');
    }

    public function testCanAccessCreateUsers()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockRole);
        });

        $response = $this->get(route('admin.user.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data User');
    }

    public function testCanCreateUserSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.user.store'), [
            'name' => 'string',
            'email' => 'string@mail.com',
            'password' => '123456890',
            'password_confirmation' => '123456890',
            'username' => 'string123',
            'role_id' => 'string'
        ]);

        $response->assertRedirect(route('admin.user.create'));
    }

    public function testCreateUserFailed()
    {
        $response = $this->json('POST', route('admin.user.store'), [
            'name' => 'string',
            'email' => 'string',
            'password' => '123456890',
            'password_confirmation' => '123456890',
            'username' => 'string123',
            'role_id' => 'string'
        ]);

        $response->assertStatus(422);
    }

    public function testCanAccessEditUsers()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockRole);
        });

        $response = $this->get(route('admin.user.edit', ['id' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data User');
    }

    public function testCanEditUserSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('put')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.user.update', ['id' => $this->mockData['data'][0]['id']]), [
            'name' => 'string',
            'email' => 'string@mail.com',
            'password' => '123456890',
            'password_confirmation' => '123456890',
            'username' => 'string123',
            'role_id' => 'string',
            'status' => 'active'
        ]);

        $response->assertRedirect(route('admin.user.edit', ['id' => $this->mockData['data'][0]['id']]));
    }

    public function testCanEditUserFailed()
    {
        $response = $this->json('POST', route('admin.user.update', ['id' => $this->mockData['data'][0]['id']]), [
            'name' => 'string',
            'email' => 'string@',
            'role_id' => 'string',
            'status' => 'active'
        ]);

        $response->assertStatus(422);
    }

    public function testDeleteSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('deleteByID')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->delete(route('admin.user.delete', ['id' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
