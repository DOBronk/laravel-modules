<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_codeanalyzer_main_page_loads_successful(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/codeanalyzer');

        $response->assertStatus(200);
    }

    public function test_codeanalyzer_create_job_step_one_loads_successful(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/codeanalyzer/create-1');

        $response->assertStatus(200);
    }

}
