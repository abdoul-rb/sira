<?php

declare(strict_types=1);

namespace App\Filament\Resources\PwaInstallations;

use App\Filament\Resources\PwaInstallations\Pages;
use App\Models\PwaInstallation;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PwaInstallationResource extends Resource
{
    protected static ?string $model = PwaInstallation::class;

    protected static ?string $navigationLabel = 'PWA Installations';

    protected static ?string $modelLabel = 'PWA Installation';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static ?string $recordTitleAttribute = 'platform';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Utilisateur')
                    ->sortable()
                    ->placeholder('Anonyme'),

                TextColumn::make('platform')
                    ->label('Plateforme')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'android' => 'success',
                        'ios' => 'info',
                        'desktop' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('ip_address')
                    ->label('Adresse IP')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('installed_at')
                    ->label('Installé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('installed_at', 'desc')
            ->filters([
                SelectFilter::make('platform')
                    ->label('Plateforme')
                    ->options([
                        'android' => 'Android',
                        'ios' => 'iOS',
                        'desktop' => 'Desktop',
                        'unknown' => 'Inconnu',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePwaInstallations::route('/'),
        ];
    }
}
