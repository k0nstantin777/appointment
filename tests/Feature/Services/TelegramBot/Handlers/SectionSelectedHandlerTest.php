<?php

namespace Tests\Feature\Services\TelegramBot\Handlers;

use App\Models\Section;
use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Handlers\SectionSelectedHandler;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use App\Services\TelegramBot\Models\Appointment;
use App\Services\TelegramBot\Storages\AppointmentStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Tests\TestCase;
use Tests\Traits\TelegramBotApiMock;

class SectionSelectedHandlerTest extends TestCase
{
    use TelegramBotApiMock;
    use RefreshDatabase;

    public function testHandle(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);

        $section = Section::factory()->create();

        $api->setCallbackQueryUpdate([
            'data' => app(ButtonParamHelper::class)
                ->encode([AppointmentParam::SECTION, $section->id])
        ]);

        $storage = app(AppointmentStorage::class);
        $storage->save($api->getWebhookUpdate()->getChat()->id, new Appointment());

        $handler = app(SectionSelectedHandler::class);
        $handler->handle($api->getWebhookUpdate());

        $this->assertEquals($api->getSentMessage(), [
            "chat_id" => 468431435,
            "text" => "Выбрано: " . $section->name,
            'reply_markup' => Keyboard::remove(),
        ]);
    }

    public function testHandleSkipByEmptyAppointment(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);

        $section = Section::factory()->create();
        $api->setCallbackQueryUpdate([
            'data' => app(ButtonParamHelper::class)
                ->encode([AppointmentParam::SECTION, $section->id])
        ]);

        $handler = app(SectionSelectedHandler::class);
        $handler->handle($api->getWebhookUpdate());

        $this->assertEquals($api->getSentMessage(), []);
    }

    public function testHandleSkipBySectionAlreadySet(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);

        $section = Section::factory()->create();
        $api->setCallbackQueryUpdate([
            'data' => app(ButtonParamHelper::class)
                ->encode([AppointmentParam::SECTION, $section->id])
        ]);

        $storage = app(AppointmentStorage::class);
        $appointment = new Appointment();
        $appointment->setSectionId($section->id);
        $storage->save($api->getWebhookUpdate()->getChat()->id, $appointment);

        $handler = app(SectionSelectedHandler::class);
        $handler->handle($api->getWebhookUpdate());

        $this->assertEquals($api->getSentMessage(), []);
    }

    public function testHandleSkipByMessageReceived(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);

        $storage = app(AppointmentStorage::class);
        $appointment = new Appointment();
        $storage->save($api->getWebhookUpdate()->getChat()->id, $appointment);

        $handler = app(SectionSelectedHandler::class);
        $handler->handle($api->getWebhookUpdate());

        $this->assertEquals($api->getSentMessage(), []);
    }

    public function testHandleSkipByErrorReceivedCallbackQueryData(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);
        $api->setCallbackQueryUpdate([
            'data' => 'random string'
        ]);

        $storage = app(AppointmentStorage::class);
        $appointment = new Appointment();
        $storage->save($api->getWebhookUpdate()->getChat()->id, $appointment);

        $handler = app(SectionSelectedHandler::class);
        $handler->handle($api->getWebhookUpdate());

        $this->assertEquals($api->getSentMessage(), []);
    }
}
