<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->label('Entreprise')
                    ->relationship('company', 'name')
                    ->required(),
                Select::make('customer_id')
                    ->label('Client')
                    ->relationship('customer', 'id'),
                /* Select::make('warehouse_id')
                    ->relationship('warehouse', 'name'), */
                
                /* Select::make('status')
                    ->options(OrderStatus::class)
                    ->required(), */
                TextInput::make('discount')
                    ->label('Rémise')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('advance')
                    ->label('Avance')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('payment_status')
                    ->label('Statut de paiement')
                    ->options(PaymentStatus::class)
                    ->columnSpanFull(),
                TextInput::make('subtotal')
                    ->label('Sous total')
                    ->numeric(),
                TextInput::make('total_amount')
                    ->label('Total')
                    ->numeric(),
                DateTimePicker::make('paid_at')->label('Date de paiement'),
                DateTimePicker::make('delivered_at')->label('Date de livraison'),
                DateTimePicker::make('cancelled_at')->label('Date de annulation'),
            ]);
    }
}
