<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum OrderStatus: string
{
    use EnumHelpers;

    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case IN_PREPARATION = 'in_preparation';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::CONFIRMED => 'Confirmée',
            self::IN_PREPARATION => 'En préparation',
            self::SHIPPED => 'Expédiée',
            self::DELIVERED => 'Livrée',
            self::CANCELLED => 'Annulée',
        };
    }
} 