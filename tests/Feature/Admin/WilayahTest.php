<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class WilayahTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withSession(['token' => $this->session]);

        $this->mock = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                    "provinces" => [
                        "id" => "string",
                        "name" => "string"
                    ]
                ]
            ]
        ];

        $this->mockProvince = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                ]
            ]
        ];
    }

    public function testCanAccessIndexWilayah()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn(['data' => $this->mock['data']]);
        });

        $this->get(route('admin.wilayah.index'))
            ->assertStatus(200)
            ->assertSee('Data Wilayah')
            ->assertSee($this->mock['data'][0]['name']);
    }

    public function testAccessCreateWilayah()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn(['data' => $this->mockProvince['data']]);
        });

        $response = $this->get(route('admin.wilayah.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data Wilayah');
    }

    public function testSuccessStoreWilayah()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->mock);
        });

        $response = $this->post(route('admin.wilayah.store'), [
            'name' => 'string',
            'province_ids' => [
                'string',
                'string'
            ],
        ]);

        $response->assertRedirect(route('admin.wilayah.index'));
    }

    public function testSuccessDeleteWilayah()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('deleteByID')
                ->once()
                ->andReturn($this->mock);
        });

        $response = $this->delete(route('admin.wilayah.destroy', ['wilayah' => $this->mock['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
