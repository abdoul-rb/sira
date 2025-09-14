<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum PaymentStatus: string
{
    use EnumHelpers;

    case CASH = 'cash';
    case MOBILE_MONEY = 'mobile-money';
    case CREDIT = 'credit';

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::MOBILE_MONEY => 'Mobile Money',
            self::CREDIT => 'Crédit',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CASH => 'bg-blue-50 text-blue-700 inset-ring inset-ring-blue-700/10',
            self::MOBILE_MONEY => 'bg-sky-50 text-sky-700 inset-ring inset-ring-sky-700/10', 
            self::CREDIT => 'bg-cyan-50 text-cyan-700 inset-ring inset-ring-cyan-700/10',
        };
    }
} 