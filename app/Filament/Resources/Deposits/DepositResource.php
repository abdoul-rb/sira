<?php

declare(strict_types=1);

namespace App\Filament\Resources\Deposits;

use App\Filament\Resources\Deposits\Pages\ManageDeposits;
use App\Models\Company;
use App\Models\Deposit;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use UnitEnum;

class DepositResource extends Resource
{
    protected static ?string $model = Deposit::class;

    protected static string | UnitEnum | null $navigationGroup = 'Ventes & Finances';

    protected static ?string $navigationLabel = 'Versements';

    protected static ?string $modelLabel = 'Versements';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->label('Entreprise')
                    ->relationship('company', 'name')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('reference')
                    ->required(),
                TextInput::make('label')
                    ->label('Libellé'),
                TextInput::make('amount')
                    ->label('Montant')
                    ->required()
                    ->numeric(),
                Select::make('bank')
                    ->label('Banque')
                    ->options(['BNG', 'UBA', 'Ecobank', 'SGBG', 'BSIC', 'Autre']),
                DatePicker::make('deposited_at')
                    ->label('Date de depôt'),
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
            ->recordTitleAttribute('label')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('company.name')
                    ->label('Entreprise')
                    ->searchable(),
                TextColumn::make('reference')
                    ->searchable(),
                TextColumn::make('label')
                    ->label('Libellé')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Montant')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('bank')
                    ->label('Banque')
                    ->searchable(),
                TextColumn::make('deposited_at')
                    ->label('Date de depôt')
                    ->date()
                    ->sortable(),
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
            'index' => ManageDeposits::route('/'),
        ];
    }
}
