<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TestimonyTest extends TestCase
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
                    "content" => "string",
                    "photo" => "string",
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
    public function testAccessIndexTestimony()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });

        $this->get(route('admin.testimonies.index'))
            ->assertStatus(200)
            ->assertSee('Data Testimony')
            ->assertSee('Name')
            ->assertSee($this->mockData['data'][0]['name']);
    }

    public function testAccessShowTestimony()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.testimonies.show', ['testimony' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('Show Data Testimony');
    }

    public function testAccessCreateTestimony()
    {
        $response = $this->get(route('admin.testimonies.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data Testimony');
    }

    public function testSuccessStoreTestimony()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('formData')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.testimonies.store'), [
            'name' => 'string',
            'content' => "String",
            'photo_file' => UploadedFile::fake()->image('photo1.jpg')
        ]);

        $response->assertRedirect(route('admin.testimonies.index'));
    }

    public function testFailedStoreTestimony()
    {
        $response = $this->json('post', route('admin.testimonies.store'), [
            'name' => 'string',
            'content' => "String",
            'photo_file' => ''
        ]);

        $response->assertStatus(422);
    }

    public function testAccessEditTestimony()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.testimonies.edit', ['testimony' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data Testimony');
    }

    public function testSuccessUpdateTestimony()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('formData')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.testimonies.update', ['testimony' => $this->mockData['data'][0]['id']]), [
            'name' => 'string',
            'content' => "String",
            '_method' => 'put'
        ]);

        $response->assertRedirect(route('admin.testimonies.index'));
    }

    public function testFailedUpdateTestimony()
    {
        $response = $this->json('post', route('admin.testimonies.update', ['testimony' => $this->mockData['data'][0]['id']]), [
            'name' => 'string',
            'content' => '',
            'photo_file' => UploadedFile::fake()->image('photo1.jpg'),
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

        $response = $this->delete(route('admin.testimonies.destroy', ['testimony' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
