<?php

namespace App\Filament\Resources\Suppliers;

use App\Filament\Resources\Suppliers\Pages\ManageSuppliers;
use App\Models\Company;
use App\Models\Supplier;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use UnitEnum;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static string | UnitEnum | null $navigationGroup = 'Achats & Stocks';

    protected static ?string $navigationLabel = 'Fournisseurs';

    protected static ?string $modelLabel = 'Fournisseur';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingStorefront;

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
                Toggle::make('main')
                    ->label('Princiaple')
                    ->required(),
                TextInput::make('email')
                    ->label('Adresse email')
                    ->email(),
                TextInput::make('phone_number')
                    ->label('Numéro de téléphone')
                    ->tel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('company.name')
                    ->label('Entreprise')
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
            ])
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('company.name')
                    ->label('Entreprise')
                    ->columnSpanFull()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nom')
                    ->columnSpanFull()
                    ->searchable(),
                IconColumn::make('main')
                    ->label('Princiaple')
                    ->boolean(),
                TextColumn::make('email')
                    ->label('Adresse email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label('Numéro de téléphone')
                    ->searchable(),
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
                SelectFilter::make('company_id')
                    ->label('Entreprise')
                    ->options(Company::pluck('name', 'id'))
                    ->searchable(),
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
            'index' => ManageSuppliers::route('/'),
        ];
    }
}
