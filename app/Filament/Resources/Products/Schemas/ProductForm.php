<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->columnSpanFull()
                    ->relationship('company', 'name')
                    ->required(),
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                TextInput::make('sku')
                    ->label('SKU'),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('featured_image')
                    ->label('Image')
                    ->columnSpanFull()
                    ->image(),
                TextInput::make('price')
                    ->label('Prix de vente')
                    ->required()
                    ->numeric()
                    ->prefix('€'),
                TextInput::make('stock_quantity')
                    ->label('Quantité')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
