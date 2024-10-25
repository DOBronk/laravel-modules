<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SanctumTest extends TestCase
{
    public function test_api_user_can_be_retrieved(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['super-user']
        );

        $response = $this->get('/api/user');

        $response->assertOk();
    }
}
