<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class RoleTest extends TestCase
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
    public function testCanAccessIndexRoles()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });

        $this->get(route('admin.roles.index'))
            ->assertStatus(200)
            ->assertSee('Data Role')
            // ->assertSee('Name')
            // ->assertSee($this->mockData['data'][0]['name'])
            ->assertSee('Role Name')
            ->assertSee($this->mockData['data'][0]['display_name']);
    }

    public function testCanAccessCreateRoles()
    {
        $response = $this->get(route('admin.roles.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data Role');
    }

    public function testCanCreateRolesuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.roles.store'), [
            'name' => 'string',
            'display_name' => 'string'
        ]);

        $response->assertRedirect(route('admin.roles.index'));
    }

    public function testCanAccessEditRoles()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.roles.edit', ['id' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data Role');
    }

    public function testCanEditRolesuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('put')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.roles.update', ['id' => $this->mockData['data'][0]['id']]), [
            'name' => 'string',
            'display_name' => 'string'
        ]);

        $response->assertRedirect(route('admin.roles.index'));
    }

    public function testDeleteSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('deleteByID')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->delete(route('admin.roles.delete', ['id' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
