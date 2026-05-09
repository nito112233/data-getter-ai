<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_guests_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_filament_dashboard(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/')
            ->assertOk();
    }

    public function test_authenticated_user_can_view_sprint_one_resources(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/sources')->assertOk();
        $this->get('/scan-runs')->assertOk();
        $this->get('/listings')->assertOk();
    }
}
