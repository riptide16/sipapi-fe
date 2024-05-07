<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubdistrictTest extends TestCase
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
                    "city" => [
                        "id" => "string",
                        "name" => "string"
                    ]
                ]
            ]
        ];

        $this->mockCity = [
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                    "type" => "string",
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
            ->assertSee('Kecamatan')
            ->assertStatus(200);
    }

    public function testCanAccessShowSubdistrict()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.regions.subdistricts.show', ['subdistrict' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('View Data Kecamatan');
    }

    public function testCanAccessCreateSubdistrict()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockCity);
        });

        $response = $this->get(route('admin.regions.subdistricts.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data Kecamatan');
    }

    public function testCanSuccessStoreSubdistrict()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.regions.subdistricts.store'), [
            'name' => 'string',
            'city_id' => 'string'
        ]);

        $response->assertRedirect(route('admin.regions.index'));
    }

    public function testCanFailedStoreSubdistrict()
    {
        $response = $this->json('POST', route('admin.regions.subdistricts.store'), [
            'name' => ''
        ]);

        $response->assertStatus(422);
    }

    public function testCanAccessEditSubdistrict()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockCity);
        });

        $response = $this->get(route('admin.regions.subdistricts.edit', ['subdistrict' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data Kecamatan');
    }

    public function testCanSuccessEditSubdistrict()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('updateByID')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->put(route('admin.regions.subdistricts.update', ['subdistrict' => $this->mockData['data'][0]['id']]), [
            'name' => 'stringS',
            'city_id' => 'string'
        ]);

        $response->assertRedirect(route('admin.regions.index'));
    }

    public function testCanFailedEditSubdistrict()
    {
        $response = $this->json('PUT', route('admin.regions.subdistricts.update', ['subdistrict' => $this->mockData['data'][0]['id']]), [
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

        $response = $this->delete(route('admin.regions.subdistricts.destroy', ['subdistrict' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
