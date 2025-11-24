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

    public function color(): string
    {
        return match ($this) {
            self::LEAD => 'bg-cyan-50 text-cyan-600',
            self::CUSTOMER => 'bg-green-50 text-green-600',
        };
    }
}
