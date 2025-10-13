<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum QuotationStatus: string
{
    use EnumHelpers;

    case DRAFT = 'draft';
    case SENT = 'sent';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Brouillon',
            self::SENT => 'Envoyé',
            self::ACCEPTED => 'Accepté',
            self::REJECTED => 'Refusé',
            self::EXPIRED => 'Expiré',
        };
    }
} 