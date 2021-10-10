<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\TelegramBotApiMock;

class TelegramWebhookControllerTest extends TestCase
{
    use TelegramBotApiMock;
    use RefreshDatabase;

    public function testInvoke(): void
    {
        $this->actingAs(User::factory()->create());

        $this->setUpTelegramBotApiMock();

        $response = $this->post(route('telegram-webhook'));

        $response->assertStatus(200);
    }
}
