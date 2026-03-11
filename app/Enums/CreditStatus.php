<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum CreditStatus: string
{
    use EnumHelpers;

    case PENDING = 'pending';
    case PAID = 'paid';
    case OVERDUE = 'overdue';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En cours',
            self::PAID => 'Soldé',
            self::OVERDUE => 'En retard',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'bg-yellow-50 text-yellow-700 inset-ring inset-ring-yellow-700/10',
            self::PAID => 'bg-green-50 text-green-700 inset-ring inset-ring-green-700/10',
            self::OVERDUE => 'bg-red-50 text-red-700 inset-ring inset-ring-red-700/10',
        };
    }
}
