<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum ExpenseCategory: string
{
    use EnumHelpers;

    case ELECTRICITY = 'electricity';
    case RENT = 'rent';
    case TRANSPORT = 'transport';
    case SUPPLIES = 'supplies';
    case SALARIES = 'salaries';
    case TAX = 'tax';
    case CNPS = 'CNPS_contribution';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::ELECTRICITY => 'Électricité',
            self::RENT => 'Loyer',
            self::TRANSPORT => 'Transport',
            self::SUPPLIES => 'Fournitures',
            self::SALARIES => 'Salaires',
            self::TAX => 'Impôt',
            self::CNPS => 'Cotisation CNPS',
            self::OTHER => 'Autres',
        };
    }
}
