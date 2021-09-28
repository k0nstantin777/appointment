<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static NEW()
 * @method static static CONFIRMED()
 * @method static static CANCELLED()
 * @method static static COMPLETED()
 */
final class VisitStatus extends Enum
{
    public const NEW = 'new';
    public const CONFIRMED = 'confirmed';
    public const CANCELLED = 'cancelled';
    public const COMPLETED = 'completed';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::NEW: return 'Новый';
            case self::CONFIRMED: return 'Подтвержденный';
            case self::CANCELLED: return 'Отмененный';
            case self::COMPLETED: return 'Завершенный';
            default: parent::getDescription($value);
        }
    }
}
