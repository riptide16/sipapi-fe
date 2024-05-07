<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class InstrumentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withSession(['token' => $this->session]);

        $this->instrumentComponent = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                    "category" => "string",
                    "weight" => 10,
                    "type" => "main",
                    "order" => 1
                ]
            ]
        ];

        $this->instrumentFirstSubComponent = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                    "category" => "string",
                    "weight" => null,
                    "type" => "sub_1",
                    "order" => 1,
                    "parent" => [
                        "id" => "string",
                        "name" => "string",
                        "category" => "string",
                        "weight" => 10,
                        "type" => "main",
                        "order" => 1
                    ]
                ]
            ]
        ];

        $this->instrumentSecondSubComponent = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                    "category" => "string",
                    "weight" => null,
                    "type" => "sub_2",
                    "order" => 1,
                    "parent" => [
                        "id" => "string",
                        "name" => "string",
                        "category" => "string",
                        "weight" => null,
                        "type" => "sub_1",
                        "order" => 1,
                        "parent" => [
                            "id" => "string",
                            "name" => "string",
                            "category" => "string",
                            "weight" => 10,
                            "type" => "main",
                            "order" => 1
                        ]
                    ]
                ]
            ]
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanAccessIndexInstrumentComponent()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->instrumentComponent);
        });

        $this->get(route('admin.instruments.index'))
            ->assertStatus(200)
            ->assertSee('Data Instrument')
            ->assertSee('Komponen')
            ->assertSee($this->instrumentComponent['data'][0]['name'])
            ->assertSee('Bobot')
            ->assertSee($this->instrumentComponent['data'][0]['weight']);
    }

    public function testCanAccessCreateInstrumentComponent()
    {
        $response = $this->get(route('admin.instruments.create', ['type' => 'main']));

        $response->assertStatus(200)
            ->assertSee('Input Data Component');
    }

    public function testCanCreateInstrumentComponentSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->instrumentComponent);
        });

        $response = $this->post(route('admin.instruments.store'), [
            'name' => 'string',
            'category' => 'string',
            'weight' => 10,
            'type' => 'main',
            'order' => 1
        ]);

        $response->assertRedirect(route('admin.instruments.index'));
    }

    public function testCanAccessEditInstrumentComponent()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->instrumentComponent['data'][0]]);
        });

        $response = $this->get(route('admin.instruments.edit', ['id' => $this->instrumentComponent['data'][0]['id'], 'type' => 'main']));

        $response->assertStatus(200)
            ->assertSee('Edit Data Component');
    }

    public function testCanEditInstrumentComponentSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('put')
                ->once()
                ->andReturn($this->instrumentComponent);
        });

        $response = $this->post(route('admin.instruments.update', ['id' => $this->instrumentComponent['data'][0]['id']]), [
            'name' => 'string',
            'category' => 'string',
            'weight' => 2,
            'type' => 'main',
            'order' => 1
        ]);

        $response->assertRedirect(route('admin.instruments.index'));
    }

    public function testDeleteSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('deleteByID')
                ->once()
                ->andReturn($this->instrumentComponent);
        });

        $response = $this->delete(route('admin.instruments.delete', ['id' => $this->instrumentComponent['data'][0]['id']]));

        $response->assertStatus(200);
    }

    public function testCanAccessCreateInstrumentFirstSubComponent()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->instrumentComponent);
        });

        $response = $this->get(route('admin.instruments.create', ['type' => 'sub_1']));

        $response->assertStatus(200)
            ->assertSee('Input Data Component');
    }

    public function testCanCreateInstrumentFirstSubComponentSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->instrumentFirstSubComponent);
        });

        $response = $this->post(route('admin.instruments.store'), [
            'id' => 'string',
            'name' => 'string',
            'category' => 'string',
            'weight' => null,
            'type' => 'sub_1',
            'order' => 1,
            'parent' => [
                'id' => 'string',
                'name' => 'string',
                'category' => 'string',
                'weight' => 10,
                'type' => 'main',
                'order' => 1
            ]
        ]);

        $response->assertRedirect(route('admin.instruments.index'));
    }

    public function testCanAccessEditInstrumentFirstSubComponent()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->instrumentFirstSubComponent['data'][0]]);
        });

        $response = $this->get(route('admin.instruments.edit', ['id' => $this->instrumentFirstSubComponent['data'][0]['id'], 'type' => 'main']));

        $response->assertStatus(200)
            ->assertSee('Edit Data Component');
    }

    public function testCanEditInstrumentFirstSubComponentSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('put')
                ->once()
                ->andReturn($this->instrumentFirstSubComponent);
        });

        $response = $this->post(route('admin.instruments.update', ['id' => $this->instrumentFirstSubComponent['data'][0]['id']]), [
            'id' => 'string',
            'name' => 'string',
            'category' => 'string',
            'weight' => null,
            'type' => 'sub_1',
            'order' => 1,
            'parent' => [
                'id' => 'string',
                'name' => 'string',
                'category' => 'string',
                'weight' => 10,
                'type' => 'main',
                'order' => 1
            ]
        ]);

        $response->assertRedirect(route('admin.instruments.index'));
    }

    public function testCanAccessCreateInstrumentSecondSubComponent()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->instrumentFirstSubComponent);
        });

        $response = $this->get(route('admin.instruments.create', ['type' => 'sub_2']));

        $response->assertStatus(200)
            ->assertSee('Input Data Component');
    }

    public function testCanCreateInstrumentSecondSubComponentSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('createNew')
                ->once()
                ->andReturn($this->instrumentFirstSubComponent);
        });

        $response = $this->post(route('admin.instruments.store'), [
            'id' => 'string',
            'name' => 'string',
            'category' => 'string',
            'weight' => null,
            'type' => 'sub_2',
            'order' => 1,
            'parent' => [
                'id' => 'string',
                'name' => 'string',
                'category' => 'string',
                'weight' => null,
                'type' => 'sub_1',
                'order' => 1,
                'parent' => [
                    'id' => 'string',
                    'name' => 'string',
                    'category' => 'string',
                    'weight' => 10,
                    'type' => 'main',
                    'order' => 1
                ]
            ]
        ]);

        $response->assertRedirect(route('admin.instruments.index'));
    }

    public function testCanAccessEditInstrumentSecondSubComponent()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->instrumentSecondSubComponent['data'][0]]);
        });

        $response = $this->get(route('admin.instruments.edit', ['id' => $this->instrumentSecondSubComponent['data'][0]['id'], 'type' => 'main']));

        $response->assertStatus(200)
            ->assertSee('Edit Data Component');
    }

    public function testCanEditInstrumentSecondSubComponentSuccess()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('put')
                ->once()
                ->andReturn($this->instrumentSecondSubComponent);
        });

        $response = $this->post(route('admin.instruments.update', ['id' => $this->instrumentSecondSubComponent['data'][0]['id']]), [
            'id' => 'string',
            'name' => 'string',
            'category' => 'string',
            'weight' => null,
            'type' => 'sub_2',
            'order' => 1,
            'parent' => [
                'id' => 'string',
                'name' => 'string',
                'category' => 'string',
                'weight' => null,
                'type' => 'sub_1',
                'order' => 1,
                'parent' => [
                    'id' => 'string',
                    'name' => 'string',
                    'category' => 'string',
                    'weight' => 10,
                    'type' => 'main',
                    'order' => 1
                ]
            ]
        ]);

        $response->assertRedirect(route('admin.instruments.index'));
    }
}
