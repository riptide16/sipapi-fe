<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailTemplateTest extends TestCase
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
                    "slug" => "string",
                    "name" => "string",
                    "subject" => "string",
                    "body" => "string",
                    "action_button" => "string",
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s')
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
    public function testAccessIndexEmailTemplate()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });

        $this->get(route('admin.email_templates.index'))
            ->assertStatus(200)
            ->assertSee('Data Email Template')
            ->assertSee('Nama Email Template')
            ->assertSee($this->mockData['data'][0]['name']);
    }

    public function testAccessShowEmailTemplate()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.email_templates.show', ['email_template' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)->assertSee('Show Data Email Template');
    }

    public function testAccessEditEmailTemplate()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockData['data'][0]]);
        });

        $response = $this->get(route('admin.email_templates.edit', ['email_template' => $this->mockData['data'][0]['id']]));

        $response->assertStatus(200)
            ->assertSee('Edit Data Email Template');
    }

    public function testSuccessUpdateEmailTemplate()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('put')
                ->once()
                ->andReturn($this->mockData);
        });

        $response = $this->post(route('admin.email_templates.update', ['email_template' => $this->mockData['data'][0]['id']]), [
            'subject' => 'string',
            'body' => 'string',
            'action_button' => 'string',
            '_method' => 'PUT'
        ]);

        $response->assertRedirect(route('admin.email_templates.index'));
    }

    public function testFailedUpdateEmailTemplate()
    {
        $response = $this->json('post', route('admin.email_templates.update', ['email_template' => $this->mockData['data'][0]['id']]), [
            'subject' => 'string',
            'body' => '',
            'action_button' => '',
            '_method' => 'PUT'
        ]);

        $response->assertStatus(422);
    }
}
