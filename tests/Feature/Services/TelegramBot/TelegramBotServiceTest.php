<?php

namespace Tests\Feature\Services\TelegramBot;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Section;
use App\Models\Service;
use App\Services\TelegramBot\Handlers\AppointmentCompletedHandler;
use App\Services\TelegramBot\Handlers\CategorySelectedHandler;
use App\Services\TelegramBot\Handlers\CreateVisitHandler;
use App\Services\TelegramBot\Handlers\DateSelectedHandler;
use App\Services\TelegramBot\Handlers\EmailGivenHandler;
use App\Services\TelegramBot\Handlers\EmployeeSelectedHandler;
use App\Services\TelegramBot\Handlers\InputEmailHandler;
use App\Services\TelegramBot\Handlers\InputPhoneHandler;
use App\Services\TelegramBot\Handlers\PhoneGivenHandler;
use App\Services\TelegramBot\Handlers\SectionSelectedHandler;
use App\Services\TelegramBot\Handlers\SelectCategoryHandler;
use App\Services\TelegramBot\Handlers\SelectEmployeeHandler;
use App\Services\TelegramBot\Handlers\SelectSectionHandler;
use App\Services\TelegramBot\Handlers\SelectServiceHandler;
use App\Services\TelegramBot\Handlers\SelectVisitDateHandler;
use App\Services\TelegramBot\Handlers\SelectVisitTimeHandler;
use App\Services\TelegramBot\Handlers\ServiceSelectedHandler;
use App\Services\TelegramBot\Handlers\ShowCurrentVisitHandler;
use App\Services\TelegramBot\Handlers\VisitTimeSelectedHandler;
use App\Services\TelegramBot\Models\Appointment;
use App\Services\TelegramBot\Storages\AppointmentStorage;
use App\Services\TelegramBot\TelegramBotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Telegram\Bot\Api;
use Tests\TestCase;
use Tests\Traits\TelegramBotApiMock;

class TelegramBotServiceTest extends TestCase
{
    use TelegramBotApiMock;
    use RefreshDatabase;

    public function testGetHandlerNotFilledAppointment(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);

        $service = app(TelegramBotService::class);

        $handler = $service->getHandler($api->getWebhookUpdate());

        $handlersChain = [
            SelectSectionHandler::class,
            SectionSelectedHandler::class,
            SelectCategoryHandler::class,
            CategorySelectedHandler::class,
            SelectServiceHandler::class,
            ServiceSelectedHandler::class,
            SelectVisitDateHandler::class,
            DateSelectedHandler::class,
            SelectEmployeeHandler::class,
            EmployeeSelectedHandler::class,
            SelectVisitTimeHandler::class,
            VisitTimeSelectedHandler::class,
            InputEmailHandler::class,
        ];

        $expectedChain = [];
        foreach($handlersChain as $handlerClass) {
            if ($handler instanceof $handlerClass) {
                $expectedChain[] = $handlerClass;
                continue;
            }

            $property = new \ReflectionProperty($handler, 'nextHandler');
            $property->setAccessible(true);

            $handler = $property->getValue($handler);
            $expectedChain[] = get_class($handler);
        }

        $this->assertEquals($expectedChain, $handlersChain);
    }

    public function testGetHandlerCallbackQuery(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);
        $api->setCallbackQueryUpdate();

        Position::factory()->create();

        $storage = app(AppointmentStorage::class);

        $appointment = new Appointment();
        $appointment->setSectionId(Section::factory()->create()->id);
        $appointment->setCategoryId(Category::factory()->create()->id);
        $appointment->setServiceId(Service::factory()->create()->id);
        $appointment->setVisitDate('2021-10-21');
        $appointment->setEmployeeId(Employee::factory()->create()->id);
        $appointment->setStartTime('09:00');
        $appointment->setEndTime('11:00');

        $storage->save($api->getWebhookUpdate()->getChat()->id, $appointment);

        $service = app(TelegramBotService::class);

        $handler = $service->getHandler($api->getWebhookUpdate());

        $handlersChain = [
            SelectSectionHandler::class,
            SectionSelectedHandler::class,
            SelectCategoryHandler::class,
            CategorySelectedHandler::class,
            SelectServiceHandler::class,
            ServiceSelectedHandler::class,
            SelectVisitDateHandler::class,
            DateSelectedHandler::class,
            SelectEmployeeHandler::class,
            EmployeeSelectedHandler::class,
            SelectVisitTimeHandler::class,
            VisitTimeSelectedHandler::class,
            InputEmailHandler::class,
        ];

        $expectedChain = [];
        foreach($handlersChain as $handlerClass) {
            if ($handler instanceof $handlerClass) {
                $expectedChain[] = $handlerClass;
                continue;
            }

            $property = new \ReflectionProperty($handler, 'nextHandler');
            $property->setAccessible(true);

            $handler = $property->getValue($handler);
            $expectedChain[] = get_class($handler);
        }

        $this->assertEquals($expectedChain, $handlersChain);
    }

    public function testGetHandlerFilledAppointment(): void
    {
        $this->setUpTelegramBotApiMock();
        $api = app(Api::class);

        Position::factory()->create();

        $service = app(TelegramBotService::class);
        $storage = app(AppointmentStorage::class);

        $appointment = new Appointment();
        $appointment->setSectionId(Section::factory()->create()->id);
        $appointment->setCategoryId(Category::factory()->create()->id);
        $appointment->setServiceId(Service::factory()->create()->id);
        $appointment->setVisitDate('2021-10-21');
        $appointment->setEmployeeId(Employee::factory()->create()->id);
        $appointment->setStartTime('09:00');
        $appointment->setEndTime('11:00');

        $storage->save($api->getWebhookUpdate()->getChat()->id, $appointment);

        $handlersChain = [
            InputEmailHandler::class,
            EmailGivenHandler::class,
            InputPhoneHandler::class,
            PhoneGivenHandler::class,
            CreateVisitHandler::class,
            AppointmentCompletedHandler::class,
            ShowCurrentVisitHandler::class,
        ];

        $handler = $service->getHandler($api->getWebhookUpdate());

        $expectedChain = [];
        foreach($handlersChain as $handlerClass) {
            if ($handler instanceof $handlerClass) {
                $expectedChain[] = $handlerClass;
                continue;
            }

            $property = new \ReflectionProperty($handler, 'nextHandler');
            $property->setAccessible(true);

            $handler = $property->getValue($handler);
            $expectedChain[] = get_class($handler);
        }

        $this->assertEquals($expectedChain, $handlersChain);
    }
}
