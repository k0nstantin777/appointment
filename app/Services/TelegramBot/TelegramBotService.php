<?php

namespace App\Services\TelegramBot;

use App\Services\BaseService;
use App\Services\TelegramBot\Handlers\AppointmentCompletedHandler;
use App\Services\TelegramBot\Handlers\CategorySelectedHandler;
use App\Services\TelegramBot\Handlers\CreateVisitHandler;
use App\Services\TelegramBot\Handlers\DateSelectedHandler;
use App\Services\TelegramBot\Handlers\EmailGivenHandler;
use App\Services\TelegramBot\Handlers\EmployeeSelectedHandler;
use App\Services\TelegramBot\Handlers\ErrorHandler;
use App\Services\TelegramBot\Handlers\Handler;
use App\Services\TelegramBot\Handlers\InputEmailHandler;
use App\Services\TelegramBot\Handlers\InputPhoneHandler;
use App\Services\TelegramBot\Handlers\NothingHandler;
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
use App\Services\TelegramBot\Storages\AppointmentStorage;
use Telegram\Bot\Objects\Update;

class TelegramBotService extends BaseService
{
    public function __construct(
        private AppointmentStorage $appointmentStorage)
    {

    }

    public function getHandler(Update $update) : Handler
    {
        $chatId = $update->getChat()->id;
        if (false === $this->isFilledAppointment($chatId) ||
            $this->isCallbackUpdate($update)
        ) {
            return  $this->getFillAppointmentHandler();
        }

        if ($this->isMessageUpdate($update)) {
            return  $this->getFillClientInfoHandler();
        }

        return app(NothingHandler::class);
    }

    public function getErrorHandler() : Handler
    {
        return app(ErrorHandler::class);
    }

    private function isCallbackUpdate(Update $update): bool
    {
        return (bool) $update->callbackQuery;
    }

    private function isMessageUpdate(Update $update): bool
    {
        return (bool) $update->message;
    }

    private function getFillAppointmentHandler() : Handler
    {
        $handler = app(SelectSectionHandler::class);

        $handler->setNext(app(SectionSelectedHandler::class))
            ->setNext(app(SelectCategoryHandler::class))
            ->setNext(app(CategorySelectedHandler::class))
            ->setNext(app(SelectServiceHandler::class))
            ->setNext(app(ServiceSelectedHandler::class))
            ->setNext(app(SelectVisitDateHandler::class))
            ->setNext(app(DateSelectedHandler::class))
            ->setNext(app(SelectEmployeeHandler::class))
            ->setNext(app(EmployeeSelectedHandler::class))
            ->setNext(app(SelectVisitTimeHandler::class))
            ->setNext(app(VisitTimeSelectedHandler::class))
            ->setNext(app(InputEmailHandler::class))
        ;

        return $handler;
    }

    private function getFillClientInfoHandler() : Handler
    {
        $handler = app(InputEmailHandler::class);
        $handler->setNext(app(EmailGivenHandler::class))
            ->setNext(app(InputPhoneHandler::class))
            ->setNext(app(PhoneGivenHandler::class))
            ->setNext(app(CreateVisitHandler::class))
            ->setNext(app(AppointmentCompletedHandler::class))
            ->setNext(app(ShowCurrentVisitHandler::class))
        ;

        return $handler;
    }

    private function isFilledAppointment(int $chatId) : bool
    {
        $appointment = $this->appointmentStorage->get($chatId);

        return $appointment &&
            $appointment->getCategoryId() &&
            $appointment->getServiceId() &&
            $appointment->getVisitDate() &&
            $appointment->getEmployeeId() &&
            $appointment->getStartTime() &&
            $appointment->getEndTime();
    }
}
