<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FaqTest extends TestCase
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
                    "content" => "string",
                    "order" => 1
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
    public function testAccessIndexFAQ()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });

        $this->get(route('admin.faq.index'))
            ->assertStatus(200)
            ->assertSee('Data FAQ')
            ->assertSee('Pertanyaan')
            ->assertSee($this->mockData['data'][0]['title']);
    }

    public function testAccessShowFAQ()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.faq.show', ['faq' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('Show Data FAQ');
    }

    public function testAccessCreateFAQ()
    {
        $response = $this->get(route('admin.faq.create'));

        $response->assertStatus(200)
            ->assertSee('Input Data FAQ');
    }

    public function testSuccessStoreFAQ()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.faq.store'), [
            'title' => 'string',
            'content' => 'string',
            'order' => 1
        ]);

        $response->assertRedirect(route('admin.faq.index'));
    }

    public function testFailedStoreFAQ()
    {
        $response = $this->json('post', route('admin.faq.store'), [
            'title' => 'string',
            'content' => '',
            'order' => 1
        ]);

        $response->assertStatus(422);
    }

    public function testAccessEditFAQ()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.faq.edit', ['faq' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data FAQ');
    }

    public function testSuccessUpdateFAQ()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('put')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.faq.update', ['faq' => $this->mockData['data'][0]['id']]), [
            'title' => 'string',
            'content' => 'string',
            'order' => 1,
            '_method' => 'put'
        ]);

        $response->assertRedirect(route('admin.faq.index'));
    }

    public function testFailedUpdateFAQ()
    {
        $response = $this->json('post', route('admin.faq.update', ['faq' => $this->mockData['data'][0]['id']]), [
            'title' => 'string',
            'content' => '',
            'order' => 1,
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

        $response = $this->delete(route('admin.faq.destroy', ['faq' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200);
    }
}
