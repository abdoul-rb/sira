<?php

declare(strict_types=1);

namespace App\Filament\Resources\PwaInstallations\Pages;

use App\Filament\Resources\PwaInstallations\PwaInstallationResource;
use App\Models\PwaInstallation;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ManagePwaInstallations extends ManageRecords
{
    protected static string $resource = PwaInstallationResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Toutes')
                ->badge(PwaInstallation::active()->count()),

            'android' => Tab::make('Android')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('platform', 'android'))
                ->badge(PwaInstallation::active()->where('platform', 'android')->count()),

            'ios' => Tab::make('iOS')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('platform', 'ios'))
                ->badge(PwaInstallation::active()->where('platform', 'ios')->count()),

            'desktop' => Tab::make('Desktop')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('platform', 'desktop'))
                ->badge(PwaInstallation::active()->where('platform', 'desktop')->count()),
        ];
    }
}
