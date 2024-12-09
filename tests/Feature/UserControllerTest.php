<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use UserHelper;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_unauthorized_fail(): void
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(401);
    }
}
