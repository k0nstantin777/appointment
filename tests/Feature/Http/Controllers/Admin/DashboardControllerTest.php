<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.dashboard')
            ->assertSee('Главная панель')
        ;
    }

    public function testIndexNotAuthenticate(): void
    {
        $response = $this->get('/admin');

        $response->assertStatus(302);
    }
}
