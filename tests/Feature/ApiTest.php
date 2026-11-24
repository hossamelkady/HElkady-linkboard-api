<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_endpoint_returns_ok(): void
    {
        $this->getJson('/api/health')->assertOk()->assertJson(['status' => 'ok']);
    }

    public function test_can_create_and_list_links(): void
    {
        $this->postJson('/api/links', ['slug' => 'product-guide', 'label' => 'Product guide', 'target_url' => 'https://example.com/guide', 'clicks' => 42, 'is_active' => true])
            ->assertCreated()->assertJsonPath('data.slug', 'product-guide');

        $this->getJson('/api/links')->assertOk()->assertJsonPath('total', 1);
    }

    public function test_invalid_payload_is_rejected(): void
    {
        $this->postJson('/api/links', [])->assertUnprocessable();
    }
}
