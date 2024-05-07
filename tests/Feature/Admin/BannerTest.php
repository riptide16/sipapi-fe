<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BannerTest extends TestCase
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
                    "image" => "string",
                    "order" => 1,
                    "url" => "string",
                    "is_active" => true
                ]
            ]
        ];

        $this->mockError = [
            "errors" => [
                "string"
            ],
            "success" => false,
            "code" => "string",
            "message" => "string"
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAccessIndexBanner()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });

        $this->get(route('admin.banners.index'))
            ->assertStatus(200)
            ->assertSee('Data Banner')
            ->assertSee('Name')
            ->assertSee($this->mockData['data'][0]['name']);
    }

    public function testAccessShowBanner()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.banners.show', ['banner' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('Show Data Banner');
    }

    public function testAccessCreateBanner()
    {
        $response = $this->get(route('admin.banners.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data Banner');
    }

    public function testStoreSuccessBanner()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('formData')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.banners.store'), [
            'name' => 'string',
            'url' => 'http://www.test.com',
            'order' => 1,
            'is_active' => true,
            'image_file' => UploadedFile::fake()->image('photo1.jpg')
        ]);

        $response->assertRedirect(route('admin.banners.index'));
    }

    public function testStoreFailedBanner()
    {
        $response = $this->json('post', route('admin.banners.store'), [
            'name' => 'string',
            'url' => 'string',
            'order' => 1,
            'is_active' => true,
            'image_file' => UploadedFile::fake()->image('photo1.jpg')
        ]);

        $response->assertStatus(422);
    }

    public function testAccessEditBanner()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.banners.edit', ['banner' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data Banner');
    }

    public function testSuccessUpdateBanner()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('formData')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.banners.update', ['banner' => $this->mockData['data'][0]['id']]), [
            'is_active' => 0,
            '_method' => 'put'
        ]);

        $response->assertRedirect(route('admin.banners.index'));
    }

    public function testFailedUpdateBanner()
    {
        $response = $this->json('post', route('admin.banners.update', ['banner' => $this->mockData['data'][0]['id']]), [
            'is_active' => 'string',
            'image_file' => UploadedFile::fake()->image('photo1.jpg'),
            '_method' => 'put'
        ]);

        $response->assertStatus(422);
    }

    public function testSuccessDeleteBanner()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('deleteByID')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->delete(route('admin.banners.destroy', ['banner' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
