<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withSession(['token' => $this->session['data']['access_token']]);

        $this->mockData = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                    "type" => "string",
                    "province" => [
                        "id" => "string",
                        "name" => "string"
                    ]
                ]
            ]
        ];

        $this->mockProvince = [
            'data' => [
                [
                    'id' => 'string',
                    'name' => 'string'
                ]
            ]
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanAccessRegion()
    {
        $response = $this->get(route('admin.regions.index'));

        $response->assertSee('Master Data')
            ->assertSee('Kota/Kabupaten')
            ->assertStatus(200);
    }

    public function testCanAccessShowCity()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.regions.cities.show', ['city' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('View Data Kota');
    }

    public function testCanAccessCreateCity()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockProvince);
        });

        $response = $this->get(route('admin.regions.cities.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data Kota');
    }

    public function testCanSuccessStoreCity()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.regions.cities.store'), [
            'name' => 'string',
            'type' => 'Kabupaten',
            'province_id' => 'string'
        ]);

        $response->assertRedirect(route('admin.regions.index'));
    }

    public function testCanFailedStoreCity()
    {
        $response = $this->json('POST', route('admin.regions.cities.store'), [
            'name' => ''
        ]);

        $response->assertStatus(422);
    }

    public function testCanAccessEditCity()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockProvince);
        });

        $response = $this->get(route('admin.regions.cities.edit', ['city' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data Kota');
    }

    public function testCanSuccessEditCity()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('updateByID')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->put(route('admin.regions.cities.update', ['city' => $this->mockData['data'][0]['id']]), [
            'name' => 'stringS',
            'type' => 'Kabupaten',
            'province_id' => 'string'
        ]);

        $response->assertRedirect(route('admin.regions.index'));
    }

    public function testCanFailedEditCity()
    {
        $response = $this->json('PUT', route('admin.regions.cities.update', ['city' => $this->mockData['data'][0]['id']]), [
            "name" => ""
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

        $response = $this->delete(route('admin.regions.cities.destroy', ['city' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
