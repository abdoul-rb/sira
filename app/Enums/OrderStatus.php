<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum OrderStatus: string
{
    use EnumHelpers;

    case PENDING = 'pending';
    case PAID = 'paid';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::PAID => 'Payée',
            self::DELIVERED => 'Livrée', 
            self::CANCELLED => 'Annulée',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'bg-yellow-100 text-yellow-500',
            self::PAID => 'bg-green-100 text-green-500', 
            self::DELIVERED => 'bg-green-100 text-green-500',
            self::CANCELLED => 'bg-red-100 text-red-500',
        };
    }
} 