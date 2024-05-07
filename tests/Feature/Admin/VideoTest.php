<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class VideoTest extends TestCase
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
                    "title" => "string",
                    "youtube_id" => "string",
                    "description" => "string"
                ]
            ]
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanAccessIndexVideos()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });

        $this->get(route('admin.videos.index'))
            ->assertStatus(200)
            ->assertSee('Data Video')
            ->assertSee('Youtube Video')
            ->assertSee($this->mockData['data'][0]['youtube_id'])
            ->assertSee('Judul')
            ->assertSee($this->mockData['data'][0]['title']);
    }

    public function testCanAccessCreateVideos()
    {
        $response = $this->get(route('admin.videos.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data Video');
    }

    public function testCanCreateRolesuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.videos.store'), [
            'title' => 'string',
            'youtube_id' => 'string',
            'description' => 'string'
        ]);

        $response->assertRedirect(route('admin.videos.index'));
    }

    public function testCanAccessEditVideos()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.videos.edit', ['id' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data Video');
    }

    public function testCanEditVideoSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('put')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.videos.update', ['id' => $this->mockData['data'][0]['id']]), [
            'title' => 'string',
            'youtube_id' => 'string',
            'description' => 'string'
        ]);

        $response->assertRedirect(route('admin.videos.index'));
    }

    public function testDeleteSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('deleteByID')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->delete(route('admin.videos.delete', ['id' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
