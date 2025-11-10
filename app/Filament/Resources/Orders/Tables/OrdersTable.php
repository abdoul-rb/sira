<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Company;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('company.name')
                    ->label('Entreprise')
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
            ])
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('company.name')
                    ->label('Entreprise')
                    ->searchable(),
                TextColumn::make('order_number')
                    ->label('N° Commande')
                    ->searchable(),
                TextColumn::make('customer.firstname')
                    ->label('Client')
                    ->searchable(),
                /* TextColumn::make('status')
                    ->badge(), */
                TextColumn::make('discount')
                    ->label('Rémise')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('advance')
                    ->label('Avance')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label('Statut de paiement')
                    ->badge(),
                TextColumn::make('subtotal')
                    ->label('Sous total')
                    ->numeric()
                    ->money('XOF')
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->label('Date de paiement')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('delivered_at')
                    ->label('Date de livraison')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cancelled_at')
                    ->label('Date de annulation')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('company_id')
                    ->label('Entreprise')
                    ->options(Company::pluck('name', 'id'))
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
