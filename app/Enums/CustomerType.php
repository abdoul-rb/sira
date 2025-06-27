<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum CustomerType: string
{
    use EnumHelpers;

    case LEAD = 'lead';
    case CUSTOMER = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::LEAD => 'Prospect',
            self::CUSTOMER => 'Client',
        };
    }
} 