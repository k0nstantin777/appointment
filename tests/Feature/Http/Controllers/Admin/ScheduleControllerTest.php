<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testEdit(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/schedule?date=05/20/2021');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.schedule')
            ->assertSee('Расписание на 20/05/2021')
        ;
    }
}
