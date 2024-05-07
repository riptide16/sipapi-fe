<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class GalleryTest extends TestCase
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
                    "image" => "string",
                    "caption" => 'string',
                    "album" => [
                        "id" => 'string',
                        'name' => 'string'
                    ],
                    "published_date" => Carbon::now(),
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
    public function testAccessIndexGallery()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });

        $this->get(route('admin.galleries.index'))
            ->assertStatus(200)
            ->assertSee('Data Gallery')
            ->assertSee('Title')
            ->assertSee($this->mockData['data'][0]['title']);
    }

    public function testAccessShowBanner()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.galleries.show', ['gallery' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('Show Data Gallery');
    }

    public function testAccessCreateGallery()
    {
        $response = $this->get(route('admin.galleries.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data Gallery');
    }

    public function testSuccessStoreGallery()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('formData')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.galleries.store'), [
            'title' => 'string',
            'caption' => 'http://www.test.com',
            'album' => "String",
            'published_date' => Carbon::now(),
            'image_file' => UploadedFile::fake()->image('photo1.jpg')
        ]);

        $response->assertRedirect(route('admin.galleries.index'));
    }

    public function testFailedStoreGallery()
    {
        $response = $this->json('post', route('admin.galleries.store'), [
            'title' => 'string',
            'caption' => 'http://www.test.com',
            'album' => "String",
            'published_date' => Carbon::now(),
            'image_file' => ''
        ]);

        $response->assertStatus(422);
    }

    public function testAccessEditGallery()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.galleries.edit', ['gallery' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data Gallery');
    }

    public function testSuccessUpdateGallery()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('formData')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.galleries.update', ['gallery' => $this->mockData['data'][0]['id']]), [
            'title' => 'string',
            'caption' => 'http://www.test.com',
            'album' => "String",
            'published_date' => Carbon::now(),
            '_method' => 'put'
        ]);

        $response->assertRedirect(route('admin.galleries.index'));
    }

    public function testFailedUpdateGallery()
    {
        $response = $this->json('post', route('admin.galleries.update', ['gallery' => $this->mockData['data'][0]['id']]), [
            'title' => 'string',
            'caption' => 'http://www.test.com',
            'album' => "",
            'published_date' => Carbon::now(),
            '_method' => 'put'
        ]);

        $response->assertStatus(422);
    }

    public function testSuccessDelete()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('deleteByID')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->delete(route('admin.galleries.destroy', ['gallery' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
