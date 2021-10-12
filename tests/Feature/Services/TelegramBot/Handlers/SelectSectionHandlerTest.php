<?php

namespace Tests\Feature\Services\TelegramBot\Handlers;

use App\Models\Section;
use App\Services\Entities\SectionService;
use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Handlers\SelectSectionHandler;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use App\Services\TelegramBot\Models\Appointment;
use App\Services\TelegramBot\Storages\AppointmentStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Tests\TestCase;
use Tests\Traits\TelegramBotApiMock;

class SelectSectionHandlerTest extends TestCase
{
    use TelegramBotApiMock;
    use RefreshDatabase;

    public function testHandle(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);

        $storage = app(AppointmentStorage::class);
        $storage->save($api->getWebhookUpdate()->getChat()->id, new Appointment());

        Section::factory()->create();

        $handler = app(SelectSectionHandler::class);
        $handler->handle($api->getWebhookUpdate());

        $keyboard = new Keyboard();

        $keyboard
            ->inline()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true);

        $sections = SectionService::getInstance()->all();

        foreach ($sections as $section) {
            $keyboard->row(Keyboard::inlineButton([
                'text' => $section->name,
                'callback_data' => app(ButtonParamHelper::class)
                    ->encode([AppointmentParam::SECTION, $section->id]),
            ]));
        }

        $this->assertEquals($api->getSentMessage(), [
            "chat_id" => 468431435,
            "text" => "Выберите направление",
            'reply_markup' => $keyboard,
        ]);
    }

    public function testHandleSkipByEmptyAppointment(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);

        $handler = app(SelectSectionHandler::class);
        $handler->handle($api->getWebhookUpdate());

        $this->assertEquals($api->getSentMessage(), []);
    }

    public function testHandleSkipBySectionAlreadySet(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);

        $section = Section::factory()->create();

        $storage = app(AppointmentStorage::class);
        $appointment = new Appointment();
        $appointment->setSectionId($section->id);
        $storage->save($api->getWebhookUpdate()->getChat()->id, $appointment);

        $handler = app(SelectSectionHandler::class);
        $handler->handle($api->getWebhookUpdate());

        $this->assertEquals($api->getSentMessage(), []);
    }

    public function testHandleSkipBySectionsNotFound(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);

        $storage = app(AppointmentStorage::class);
        $appointment = new Appointment();
        $storage->save($api->getWebhookUpdate()->getChat()->id, $appointment);

        $handler = app(SelectSectionHandler::class);
        $handler->handle($api->getWebhookUpdate());

        $this->assertEquals($api->getSentMessage(), []);
    }

    public function testHandleSkipByReceivedCallbackQuery(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);
        $api->setCallbackQueryUpdate();

        $handler = app(SelectSectionHandler::class);
        $handler->handle($api->getWebhookUpdate());

        $this->assertEquals($api->getSentMessage(), []);
    }
}
