<?php

namespace Tests\Feature\Admin;

use App\Services\AdminService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class InstitutionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withSession(['token' => $this->session]);

        $this->mockInstitution = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "category" => "string",
                    "region_id" => "string",
                    "library_name" => "string",
                    "npp" => "string",
                    "agency_name" => "string",
                    "typology" => "string",
                    "address" => "string",
                    "province_id" => "string",
                    "city_id" => "string",
                    "subdistrict_id" => "string",
                    "village_id" => "string",
                    "institution_head_name" => "string",
                    "email" => "string",
                    "telephone_number" => "string",
                    "mobile_number" => "string",
                    "library_head_name" => "string",
                    "library_worker_name" => "string",
                    "registration_form_file" => "string",
                    "title_count" => "string",
                    "user_id" => "string",
                    "validated_at" => "string",
                ]
            ]
        ];

        $this->mockRegion = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                ]
            ]
        ];

        $this->mockProvince = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                ]
            ]
        ];

        $this->mockCity = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                    "type" => "string",
                    "province" => [
                        "id" => "string",
                        "name" => "string"
                    ]
                ]
            ]
        ];

        $this->mockSubdistrict = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                    "city" => [
                        "id" => "string",
                        "name" => "string"
                    ]
                ]
            ]
        ];

        $this->mockVillage = [
            'success' => true,
            'message' => 'test',
            'data' => [
                [
                    "id" => "string",
                    "name" => "string",
                    'postal_code' => 12345,
                    "subdistrict" => [
                        "id" => "string",
                        "name" => "string"
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
    public function testCanAccessIndexInstitutions()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn(['data' => $this->mockInstitution['data'][0]]);
            
            $mock->shouldReceive('getByID')
                ->andReturn(['data' => $this->mockInstitution['data'][0]]);
        });

        $this->get(route('admin.institutions.index'))
            ->assertStatus(200)
            ->assertSee('Data Kelembagaan')
            ->assertSee($this->mockInstitution['data'][0]['library_name']);
    }

    public function testCanAccessEditInstitutions()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('getByID')
                ->once()
                ->andReturn(['data' => $this->mockInstitution['data'][0]]);

            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockRegion);

            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockProvince);

            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockCity);

            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockSubdistrict);

            $mock->shouldReceive('getAll')
                ->once()
                ->andReturn($this->mockVillage);
        });

        $this->get(route('admin.institutions.edit', ['id' => $this->mockInstitution['data'][0]['id']]))
            ->assertStatus(200)
            ->assertSee('Update Data Kelembagaan')
            ->assertSee('Kategori')
            ->assertSee($this->mockInstitution['data'][0]['category'])
            ->assertSee('Nama Perpustakaan')
            ->assertSee($this->mockInstitution['data'][0]['library_name']);
    }

    public function testCanUpdateInstitutions()
    {
        $this->mock(AdminService::class, function ($mock) {
            $mock->shouldReceive('updateUploadInstitution')
                ->once()
                ->andReturn($this->mockInstitution);
        });

        $response = $this->post(route('admin.institutions.update', ['id' => $this->mockInstitution['data'][0]['id']]), [
            'id' => 'string',
            'category' => 'string',
            'region_id' => 'string',
            'library_name' => 'string',
            'npp' => 'string',
            'agency_name' => 'string',
            'typology' => 'string',
            'address' => 'string',
            'province_id' => 'string',
            'city_id' => 'string',
            'subdistrict_id' => 'string',
            'village_id' => 'string',
            'institution_head_name' => 'string',
            'email' => 'string',
            'telephone_number' => 'string',
            'mobile_number' => 'string',
            'library_head_name' => 'string',
            'library_worker_name' => 'string',
            'registration_form_file' => 'string',
            'title_count' => 'string',
        ]);

        $response->assertRedirect(route('admin.institutions.index'));
    }
}
