<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum PaymentMethod: string
{
    use EnumHelpers;

    case CASH = 'cash';
    case MOBILE_MONEY = 'mobile-money';

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::MOBILE_MONEY => 'Mobile Money',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CASH => 'bg-blue-50 text-blue-700 inset-ring inset-ring-blue-700/10',
            self::MOBILE_MONEY => 'bg-sky-50 text-sky-700 inset-ring inset-ring-sky-700/10',
        };
    }
}
