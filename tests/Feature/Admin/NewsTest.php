<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsTest extends TestCase
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
                    "body" => "string",
                    "published_date" => Carbon::now(),
                    "author" => [
                        "id" => "string",
                        "name" => "string"
                    ]
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
    public function testAccessIndexNews()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });

        $this->get(route('admin.news.index'))
            ->assertStatus(200)
            ->assertSee('Data Berita')
            ->assertSee('Judul')
            ->assertSee($this->mockData['data'][0]['title']);
    }

    public function testAccessCreateNews()
    {
        $response = $this->get(route('admin.news.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data Berita');
    }

    public function testSuccessStoreNews()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('formData')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.news.store'), [
            'title' => 'string',
            'body' => 'string',
            'published_date' => now(),
            'image_file' => UploadedFile::fake()->image('photo1.jpg')
        ]);

        $response->assertRedirect(route('admin.news.index'));
    }

    public function testFailedStoreNews()
    {
        $response = $this->json('POST', route('admin.news.store'), [
            'title' => 'string',
            'body' => '',
            'published_date' => now(),
        ]);

        $response->assertStatus(422);
    }

    public function testAccessShowNews()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.news.show', ['news' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('Show Data Berita');
    }

    public function testAccessEditNews()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.news.edit', ['news' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data Berita');
    }

    public function testSuccessUpdateNews()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('formData')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.news.update', ['news' => $this->mockData['data'][0]['id']]), [
            'title' => 'string',
            'body' => 'as',
            'published_date' => now(),
            'image_file' => UploadedFile::fake()->image('photo1.jpg'),
            '_method' => 'put'
        ]);

        $response->assertRedirect(route('admin.news.index'));
    }

    public function testFailedUpdateNews()
    {
        $response = $this->json('post', route('admin.news.update', ['news' => $this->mockData['data'][0]['id']]), [
            'title' => 'string',
            'body' => '',
            'published_date' => now(),
            'image_file' => UploadedFile::fake()->image('photo1.jpg'),
            '_method' => 'put'
        ]);

        $response->assertStatus(422);
    }

    public function testSuccessDeleteNews()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('deleteByID')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->delete(route('admin.news.destroy', ['news' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
