<?php

namespace App\Filament\Resources\Warehouses;

use App\Filament\Resources\Warehouses\Pages\ManageWarehouses;
use App\Models\Warehouse;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static string | UnitEnum | null $navigationGroup = 'Achats & Stocks';

    protected static ?string $navigationLabel = 'Emplacements';

    protected static ?string $modelLabel = 'Emplacement';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Map;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->label('Entreprise')
                    ->relationship('company', 'name')
                    ->required(),
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                TextInput::make('location')
                    ->label('Localisation'),
                Toggle::make('default')
                    ->label('Par défaut')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('company.name')
                    ->label('Entreprise')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('location')
                    ->label('Localisation')
                    ->searchable(),
                IconColumn::make('default')
                    ->label('Par défaut')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
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
            'index' => ManageWarehouses::route('/'),
        ];
    }
}
