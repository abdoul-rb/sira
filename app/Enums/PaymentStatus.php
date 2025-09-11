<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum PaymentStatus: string
{
    use EnumHelpers;

    case CASH = 'cash';
    case CREDIT_CARD = 'credit_card';
    case CREDIT = 'credit';

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::CREDIT_CARD => 'Carte de crédit',
            self::CREDIT => 'Crédit',
        };
    }
} 