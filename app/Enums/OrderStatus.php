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

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'bg-yellow-100 text-yellow-500',
            self::CONFIRMED => 'bg-green-100 text-green-500',
            self::IN_PREPARATION => 'bg-blue-100 text-blue-500',
            self::SHIPPED => 'bg-purple-100 text-purple-500',
            self::DELIVERED => 'bg-green-100 text-green-500',
            self::CANCELLED => 'bg-red-100 text-red-500',
        };
    }
} 