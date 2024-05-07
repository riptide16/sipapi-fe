<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $this->usertest = [
            'username' => 'superadmin@evalatore.com',
            'password' => 'password'
        ];

        $this->session = [
            'data' => [
                'token_type' => 'string',
                'expires_in' => 100000,
                'access_token' => 'string',
                'refresh_token' => 'string'
            ]
        ];

        $this->superAdminSession = [
            'data' => [
                'username' => 'super_admin',
                'name' => 'Super Admin',
                'email' => 'superadmin@evalatore.com',
                'role' => [
                    'name' => 'super_admin',
                ],
            ],
        ];

        $this->asesiSession = [
            'data' => [
                'username' => 'asesi',
                'name' => 'Asesi',
                'email' => 'asesi@evalatore.com',
                'role' => [
                    'name' => 'asesi',
                ],
            ],
        ];
    }
}
