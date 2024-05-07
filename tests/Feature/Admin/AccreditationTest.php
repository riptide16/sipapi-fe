<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccreditationTest extends TestCase
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
                    "code" => "string",
                    "status" => "string",
                    "notes" => "string",
                    "body" => "string",
                    "created_at" => date('Y-m-d H:i:s'),
                    "user_id" => "string"
                ]
            ]
        ];
    }

    public function testAccessIndexAccreditation()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });
        $this->withSession(['user' => $this->asesiSession]);

        $this->get(route('admin.akreditasi.index'))
            ->assertStatus(200)
            ->assertSee('Data Akreditasi')
            ->assertSee('Kode Pengajuan')
            ->assertSee(__('Akreditasi Baru'))
            ->assertDontSee(route('admin.akreditasi.show', [$this->mockData['data'][0]['id']]))
            ->assertSee($this->mockData['data'][0]['code']);
    }

    public function testAccessIndexAccreditationAsAdmin()
    {
        $this->withSession(['user' => $this->superAdminSession]);

        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockData);
        });

        $this->get(route('admin.akreditasi.index'))
            ->assertStatus(200)
            ->assertSee('Data Akreditasi')
            ->assertSee('Kode Pengajuan')
            ->assertDontSee(__('Akreditasi Baru'))
            ->assertSee(route('admin.akreditasi.show', [$this->mockData['data'][0]['id']]))
            ->assertSee($this->mockData['data'][0]['code']);
    }
}
