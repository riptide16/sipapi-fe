<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Tests\TestCase;

class VillageTest extends TestCase
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
                    'postal_code' => 12345,
                    "subdistrict" => [
                        "id" => "string",
                        "name" => "string"
                    ]
                ]
            ]
        ];

        $this->mockSubdistrict = [
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
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
            ->assertSee('Kelurahan')
            ->assertStatus(200);
    }

    public function testCanAccessShowVillage()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.regions.villages.show', ['village' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('View Data Kelurahan');
    }

    public function testCanAccessCreateVillage()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockSubdistrict);
        });

        $response = $this->get(route('admin.regions.villages.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data Kelurahan');
    }

    public function testCanSuccessStoreVillage()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.regions.villages.store'), [
            'name' => 'string',
            'postal_code' => 12345,
            'subdistrict_id' => 'string'
        ]);

        $response->assertRedirect(route('admin.regions.index'));
    }

    public function testCanFailedStoreVillage()
    {
        $response = $this->json('POST', route('admin.regions.villages.store'), [
            'name' => ''
        ]);

        $response->assertStatus(422);
    }

    public function testCanAccessEditVillage()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockSubdistrict);
        });

        $response = $this->get(route('admin.regions.villages.edit', ['village' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data Kelurahan');
    }

    public function testCanSuccessEditVillage()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('updateByID')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->put(route('admin.regions.villages.update', ['village' => $this->mockData['data'][0]['id']]), [
            'name' => 'stringS',
            'postal_code' => 12345,
            'subdistrict_id' => 'string'
        ]);

        $response->assertRedirect(route('admin.regions.index'));
    }

    public function testCanFailedEditVillage()
    {
        $response = $this->json('PUT', route('admin.regions.villages.update', ['village' => $this->mockData['data'][0]['id']]), [
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

        $response = $this->delete(route('admin.regions.villages.destroy', ['village' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
