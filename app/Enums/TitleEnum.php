<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum TitleEnum: string
{
    use EnumHelpers;

    case MONSIEUR = 'M.';
    case MADAME = 'Mme.';
    case MADEMOISELLE = 'Mlle.';

    public function label(): string
    {
        return match ($this) {
            self::MONSIEUR => __('M.'),
            self::MADAME => __('Mme.'),
            self::MADEMOISELLE => __('Mlle.'),
        };
    }
}
