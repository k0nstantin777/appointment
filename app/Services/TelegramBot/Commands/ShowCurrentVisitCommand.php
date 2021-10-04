<?php

namespace App\Services\TelegramBot\Commands;

use App\Services\TelegramBot\Handlers\ShowCurrentVisitHandler;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

/**
 * Class HelpCommand.
 */
class ShowCurrentVisitCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'show_current_visit';

    /**
     * @var string Command Description
     */
    protected $description = 'Посмотреть текущий, оформляемый визит';

    /**Storages
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        app(ShowCurrentVisitHandler::class)->handle($this->update);
    }
}
