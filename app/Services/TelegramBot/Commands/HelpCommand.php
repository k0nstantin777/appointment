<?php

namespace App\Services\TelegramBot\Commands;

use Telegram\Bot\Commands\HelpCommand as BaseHelpCommand;

/**
 * Class HelpCommand.
 */
class HelpCommand extends BaseHelpCommand
{
    protected $description = 'Вывод списка доступных команд.';
}
