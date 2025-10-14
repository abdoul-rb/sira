<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Auth user')
                    ->relationship('user', 'name'),
                Select::make('company_id')
                    ->label('Entreprise')
                    ->relationship('company', 'name')
                    ->required(),
                TextInput::make('firstname')
                    ->label('Prénom'),
                TextInput::make('lastname')
                    ->label('Nom'),
                TextInput::make('phone_number')
                    ->label('Téléphone')
                    ->tel(),
            ]);
    }
}
