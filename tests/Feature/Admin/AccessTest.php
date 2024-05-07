<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AccessTest extends TestCase
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
                    "permissions" => [
                        [
                            "id" => 'string',
                            'key' => 'string'
                        ]
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

        $this->mockMenu = [
            "data" => [
                [
                    "id" => "string",
                    "slug" => "string",
                    "title" => "string",
                    "order" => 1,
                    "permissions" => [
                        [
                            "id" => "string",
                            "key" => "string"
                        ]
                    ]
                ]
            ]
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanAccessIndexAccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });

        $this->get(route('admin.access.index'))
            ->assertStatus(200)
            ->assertSee('Data Access')
            ->assertSee('Name')
            ->assertSee($this->mockData['data'][0]['name']);
    }

    public function testCanAccessEditAccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);

            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockMenu);
        });

        $response = $this->get(route('admin.access.edit', ['id' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('Edit ' . $this->mockData['data'][0]['display_name'] . ' Access');
    }

    public function testSuccessUpdateAccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('updateByID')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.access.update', ['id' => $this->mockData['data'][0]['id']]), [
            'action' => [
                '943f0c2d-f9ab-45c6-bd8e-bf4c08e5334a',
                '943f0c2e-03b9-4712-92a1-ee7aebb0a6b2',
                '9464ea3a-1868-4549-93a5-7ce154180d8a',
                '9464ea3a-1bda-48e3-b5fd-d4bc3afe6f9b',
                '9464ea3a-1ee4-4451-ba8a-bb3e88a2aaea'
            ],
        ]);

        $response->assertRedirect(route('admin.access.index'));
    }

    public function testAccessShow()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);

            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockMenu);
        });

        $response = $this->get(route('admin.access.show', ['id' => $this->mockData['data'][0]['id']]));
        $response->assertStatus(200)->assertSee('Show ' . $this->mockData['data'][0]['display_name'] . ' Access');
    }
}
