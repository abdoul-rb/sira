<?php

declare(strict_types=1);

namespace App\Traits;

trait EnumHelpers
{
    /**
     * @return array<int, string>
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return array<string, string>
     */
    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function options(): array
    {
        return array_map(function ($item) {
            return [
                'label' => $item->label(),
                'name' => ucfirst($item->value),
                'value' => $item,
            ];
        }, self::cases());
    }

    public static function radio(string $name): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[] = [
                'label' => $case->label(),
                'value' => $case,
                'name' => $name,
            ];
        }

        return $options;
    }

    public static function checkbox(string $name): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[] = [
                'text' => $case->label(),
                'value' => $case->value,
                'name' => $name,
            ];
        }

        return $options;
    }

    public function label(): string
    {
        return $this->value;
    }
}
