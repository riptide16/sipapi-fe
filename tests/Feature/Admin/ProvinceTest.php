<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Tests\TestCase;

class ProvinceTest extends TestCase
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
            ->assertSee('Provinsi')
            ->assertStatus(200);
    }

    public function testCanAccessShowProvince()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.regions.provinces.show', ['id' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('View Data Province');
    }

    public function testCanAccessCreateProvince()
    {
        $response = $this->get(route('admin.regions.provinces.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data Provinsi');
    }

    public function testCanSuccessStoreProvince()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.regions.provinces.store'), [
            'name' => 'string'
        ]);

        $response->assertRedirect(route('admin.regions.index'));
    }

    public function testCanFailedStoreProvince()
    {
        $response = $this->json('POST', route('admin.regions.provinces.store'), [
            'name' => ''
        ]);

        $response->assertStatus(422);
    }

    public function testCanAccessEditProvince()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.regions.provinces.edit', ['id' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data Provinsi');
    }

    public function testCanSuccessEditProvince()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('put')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.regions.provinces.update', ['id' => $this->mockData['data'][0]['id']]), [
            "name" => "TESTUASA"
        ]);

        $response->assertRedirect(route('admin.regions.index'));
    }

    public function testCanFailedEditProvince()
    {
        $response = $this->json('POST', route('admin.regions.provinces.update', ['id' => $this->mockData['data'][0]['id']]), [
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

        $response = $this->delete(route('admin.regions.provinces.delete', ['id' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
