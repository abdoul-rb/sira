<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum RoleEnum: string
{
    use EnumHelpers;

    case SUPERADMIN = 'keeper-admin';
    case MANAGER = 'manager';
    case OPERATOR = 'operator';

    public function label(): string
    {
        return match ($this) {
            self::SUPERADMIN => 'Super admin',
            self::MANAGER => 'Manager',
            self::OPERATOR => 'Assistant.e/Caissier.e',
        };
    }
}
