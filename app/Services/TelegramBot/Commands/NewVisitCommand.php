<?php

namespace App\Services\TelegramBot\Commands;

use App\Services\TelegramBot\Handlers\NewVisitHandler;
use App\Services\TelegramBot\Handlers\SelectCategoryHandler;
use App\Services\TelegramBot\Handlers\SelectSectionHandler;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

/**
 * Class HelpCommand.
 */
class NewVisitCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'new_visit';

    /**
     * @var string Command Description
     */
    protected $description = 'Создать новый визит';

    /**Storages
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $newVisitHandler = app(NewVisitHandler::class);

        $newVisitHandler
            ->setNext(app(SelectSectionHandler::class))
            ->setNext(app(SelectCategoryHandler::class));

        $newVisitHandler->handle($this->update);
    }
}
